<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;

class MessageSeeder extends Seeder
{
    public function run()
    {
        // Get some users
        $users = User::take(3)->get();
        
        if ($users->count() < 2) {
            $this->command->info('Not enough users to seed messages. Please seed users first.');
            return;
        }
        
        $user1 = $users[0];
        $user2 = $users[1];
        
        $messages = [
            [
                'sender_id' => $user1->id,
                'receiver_id' => $user2->id,
                'content' => 'Hello! I need legal assistance regarding a property dispute.',
                'is_read' => true,
                'created_at' => now()->subHours(5),
            ],
            [
                'sender_id' => $user2->id,
                'receiver_id' => $user1->id,
                'content' => 'Hi there! I would be happy to help you with your property dispute. Can you provide more details?',
                'is_read' => true,
                'created_at' => now()->subHours(4)->subMinutes(30),
            ],
            [
                'sender_id' => $user1->id,
                'receiver_id' => $user2->id,
                'content' => 'Yes, it\'s about boundary issues with my neighbor. They built a fence that encroaches on my property.',
                'is_read' => true,
                'created_at' => now()->subHours(4),
            ],
            [
                'sender_id' => $user2->id,
                'receiver_id' => $user1->id,
                'content' => 'I understand. Do you have the property survey documents? That would be crucial for the case.',
                'is_read' => true,
                'created_at' => now()->subHours(3)->subMinutes(45),
            ],
            [
                'sender_id' => $user1->id,
                'receiver_id' => $user2->id,
                'content' => 'Yes, I have the original deed and a recent survey. Should I bring them to our consultation?',
                'is_read' => false,
                'created_at' => now()->subHours(2),
            ],
            [
                'sender_id' => $user2->id,
                'receiver_id' => $user1->id,
                'content' => 'Absolutely! Please bring all documents. We can schedule a meeting this week. What time works for you?',
                'is_read' => false,
                'created_at' => now()->subMinutes(30),
            ],
        ];
        
        foreach ($messages as $messageData) {
            Message::create($messageData);
        }
        
        $this->command->info('Created ' . count($messages) . ' test messages between users.');
        
        // If there's a third user, create another conversation
        if ($users->count() >= 3) {
            $user3 = $users[2];
            
            $moreMessages = [
                [
                    'sender_id' => $user3->id,
                    'receiver_id' => $user1->id,
                    'content' => 'Hey, I saw your post about legal services. Can you help with a contract review?',
                    'is_read' => false,
                    'created_at' => now()->subHour(),
                ],
                [
                    'sender_id' => $user1->id,
                    'receiver_id' => $user3->id,
                    'content' => 'Of course! Send me the contract details and I\'ll take a look.',
                    'is_read' => true,
                    'created_at' => now()->subMinutes(45),
                ],
            ];
            
            foreach ($moreMessages as $messageData) {
                Message::create($messageData);
            }
            
            $this->command->info('Created ' . count($moreMessages) . ' additional messages.');
        }
    }
}
