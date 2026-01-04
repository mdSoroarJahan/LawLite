<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Message;
use App\Models\User;

class SeedMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:seed-messages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed test messages between users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::take(3)->get();
        
        if ($users->count() < 2) {
            $this->error('Not enough users. Please seed users first.');
            return 1;
        }
        
        $user1 = $users[0];
        $user2 = $users[1];
        
        $this->info("Creating messages between {$user1->name} (ID:{$user1->id}) and {$user2->name} (ID:{$user2->id})");
        
        $messages = [
            ['sender_id' => $user1->id, 'receiver_id' => $user2->id, 'content' => 'Hello! I need legal assistance regarding a property dispute.', 'is_read' => true, 'created_at' => now()->subHours(5)],
            ['sender_id' => $user2->id, 'receiver_id' => $user1->id, 'content' => 'Hi there! I would be happy to help you. Can you provide more details?', 'is_read' => true, 'created_at' => now()->subHours(4)->subMinutes(30)],
            ['sender_id' => $user1->id, 'receiver_id' => $user2->id, 'content' => 'Yes, it\'s about boundary issues with my neighbor.', 'is_read' => true, 'created_at' => now()->subHours(4)],
            ['sender_id' => $user2->id, 'receiver_id' => $user1->id, 'content' => 'I understand. Do you have the property survey documents?', 'is_read' => true, 'created_at' => now()->subHours(3)->subMinutes(45)],
            ['sender_id' => $user1->id, 'receiver_id' => $user2->id, 'content' => 'Yes, I have the original deed and a recent survey.', 'is_read' => false, 'created_at' => now()->subHours(2)],
            ['sender_id' => $user2->id, 'receiver_id' => $user1->id, 'content' => 'Please bring all documents. What time works for you?', 'is_read' => false, 'created_at' => now()->subMinutes(30)],
        ];
        
        foreach ($messages as $messageData) {
            Message::create($messageData);
        }
        
        $this->info('Created ' . count($messages) . ' test messages.');
        
        if ($users->count() >= 3) {
            $user3 = $users[2];
            $this->info("Creating messages with {$user3->name} (ID:{$user3->id})");
            
            Message::create(['sender_id' => $user3->id, 'receiver_id' => $user1->id, 'content' => 'Hey, can you help with a contract review?', 'is_read' => false, 'created_at' => now()->subHour()]);
            Message::create(['sender_id' => $user1->id, 'receiver_id' => $user3->id, 'content' => 'Of course! Send me the contract details.', 'is_read' => true, 'created_at' => now()->subMinutes(45)]);
            
            $this->info('Created 2 additional messages.');
        }
        
        $this->info('Done! Total messages: ' . Message::count());
        return 0;
    }
}
