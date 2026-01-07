# LawLite - System Architecture Diagram

## Overview

LawLite is a bilingual (Bangla/English) legal consultation and knowledge-sharing platform built with Laravel 10. This document provides comprehensive system architecture diagrams.

---

## 1. High-Level System Architecture

```mermaid
flowchart TB
    subgraph Clients[Client Layer]
        WB[Web Browser]
        MB[Mobile Browser]
    end

    subgraph CDN[Content Delivery]
        STATIC[Static Assets - CSS/JS/Images]
    end

    subgraph AppServer[Application Server - Laravel 10]
        subgraph Presentation[Presentation Layer]
            BLADE[Blade Templates - Views]
            ROUTES[Route Handler - web.php / api.php]
        end

        subgraph Business[Business Logic Layer]
            AUTH[AuthController]
            LAWYER[LawyerController]
            APPT[AppointmentController]
            CHAT[ChatController]
            AI[AiController]
            ADMIN[AdminController]
            PAY[PaymentController]
            CASE[UserCaseController]
        end

        subgraph Services[Services Layer]
            GEMINI[GeminiService - AI Integration]
            METRICS[Metrics Service - StatsD]
            PAYMENT[Payment Service - SSLCommerz]
        end

        subgraph Middleware[Middleware Layer]
            AUTHMW[Authentication]
            ROLEMW[Role-based Access]
            CSRF[CSRF Protection]
            LOCALE[Localization]
        end
    end

    subgraph DataLayer[Data Layer]
        MYSQL[(MySQL Database)]
        CACHE[(Cache - File/Redis)]
        STORAGE[File Storage - Documents/Uploads]
    end

    subgraph ExternalServices[External Services]
        GEMINIAPI[Google Gemini API - AI Legal Assistant]
        SSLCOMMERZ[SSLCommerz - Payment Gateway]
        PUSHER[Pusher/Echo - Real-time Events]
        ELASTIC[ElasticSearch - Search Engine]
        STATSD[StatsD Server - Metrics Collection]
    end

    WB --> ROUTES
    MB --> ROUTES
    STATIC --> WB
    STATIC --> MB

    ROUTES --> Middleware
    Middleware --> Business
    Business --> Services
    Business --> BLADE

    GEMINI --> GEMINIAPI
    PAYMENT --> SSLCOMMERZ
    METRICS --> STATSD
    CHAT --> PUSHER

    Business --> MYSQL
    Business --> CACHE
    Business --> STORAGE
    AI --> ELASTIC
```

---

## 2. Layered Architecture Diagram

```mermaid
flowchart LR
    subgraph PL[Presentation Layer]
        V1[Blade Views]
        V2[Layouts]
        V3[Components]
        V4[Localization - en / bn]
    end

    subgraph CL[Controller Layer]
        C1[AuthController]
        C2[LawyerController]
        C3[AppointmentController]
        C4[ChatController]
        C5[AiController]
        C6[AdminController]
        C7[PaymentController]
    end

    subgraph SL[Service Layer]
        S1[GeminiService]
        S2[MetricsService]
        S3[PaymentService]
    end

    subgraph ML[Model Layer]
        M1[User]
        M2[Lawyer]
        M3[Appointment]
        M4[LawyerCase]
        M5[Message]
        M6[Invoice]
        M7[Article]
    end

    subgraph DL[Data Layer]
        D1[(MySQL)]
        D2[(Cache)]
        D3[File Storage]
    end

    PL --> CL
    CL --> SL
    CL --> ML
    SL --> ML
    ML --> DL
```

---

## 3. User Role and Access Architecture

```mermaid
flowchart TB
    subgraph Users[User Roles]
        U1[Regular User]
        U2[Lawyer]
        U3[Admin]
    end

    subgraph UserFeatures[Regular User Features]
        UF1[Browse Lawyers]
        UF2[Book Appointments]
        UF3[AI Legal Queries]
        UF4[View Cases]
        UF5[Chat with Lawyers]
        UF6[Read Articles]
        UF7[Make Payments]
    end

    subgraph LawyerFeatures[Lawyer Features]
        LF1[Dashboard]
        LF2[Manage Availability]
        LF3[Handle Appointments]
        LF4[Manage Cases]
        LF5[Chat with Clients]
        LF6[Generate Invoices]
        LF7[Write Articles]
        LF8[Profile Management]
    end

    subgraph AdminFeatures[Admin Features]
        AF1[Admin Dashboard]
        AF2[Verify Lawyers]
        AF3[Manage Users]
        AF4[System Analytics]
        AF5[Content Moderation]
    end

    U1 --> UserFeatures
    U2 --> LawyerFeatures
    U2 --> UserFeatures
    U3 --> AdminFeatures
    U3 --> LawyerFeatures
    U3 --> UserFeatures
```

---

## 4. AI Integration Architecture

```mermaid
flowchart LR
    subgraph Client[Client Request]
        REQ[User Query - Legal Question]
    end

    subgraph Laravel[Laravel Application]
        subgraph Controllers[Controllers]
            AIC[AiController]
            AFC[AiFeaturesController]
        end
        
        subgraph Service[Service]
            GS[GeminiService]
            MT[Metrics]
        end

        subgraph ErrorHandling[Error Handling]
            GE[GeminiException]
            RH[Retry Handler]
        end
    end

    subgraph GeminiAPI[Google Gemini API]
        EP[generateContent Endpoint]
    end

    subgraph Features[AI Features]
        F1[Legal QA]
        F2[Document Summarization]
        F3[Dhara Lookup - Law Sections]
        F4[Legal Term Definition]
        F5[Document Analysis]
        F6[Case Prediction]
        F7[Procedure Guide]
        F8[Rights Checker]
        F9[Document Drafting]
        F10[Court Fee Calculator]
        F11[Citation Generator]
        F12[Inheritance Calculator]
    end

    REQ --> Controllers
    Controllers --> GS
    GS --> EP
    EP -->|Success| GS
    EP -->|Failure| RH
    RH -->|Retry| EP
    RH -->|Max Retries| GE
    GS --> MT
    Controllers --> Features

    style GeminiAPI fill:#4285F4,color:#fff
    style GE fill:#EA4335,color:#fff
```

---

## 5. Database Entity Relationship Overview

```mermaid
erDiagram
    USERS ||--o| LAWYERS : "can be"
    USERS ||--o{ APPOINTMENTS : "books"
    USERS ||--o{ MESSAGES : "sends/receives"
    USERS ||--o{ AI_QUERIES : "makes"
    USERS ||--o{ NOTIFICATIONS : "receives"

    LAWYERS ||--o{ APPOINTMENTS : "receives"
    LAWYERS ||--o{ LAWYER_AVAILABILITIES : "sets"
    LAWYERS ||--o{ LAWYER_CASES : "manages"
    LAWYERS ||--o{ ARTICLES : "writes"
    LAWYERS ||--o{ ADMIN_VERIFICATIONS : "has"

    LAWYER_CASES ||--o{ CASE_DOCUMENTS : "contains"
    LAWYER_CASES ||--o{ CASE_TASKS : "has"

    APPOINTMENTS ||--o| INVOICES : "generates"

    USERS {
        int id PK
        string name
        string email
        string role
        string password
        timestamp created_at
    }

    LAWYERS {
        int id PK
        int user_id FK
        string bio
        string city
        json expertise
        json education
        json experience
        string bar_council_id
        boolean is_verified
    }

    APPOINTMENTS {
        int id PK
        int user_id FK
        int lawyer_id FK
        datetime appointment_date
        string type
        string status
        text notes
    }

    LAWYER_AVAILABILITIES {
        int id PK
        int lawyer_id FK
        int day_of_week
        time start_time
        time end_time
        boolean is_active
    }

    LAWYER_CASES {
        int id PK
        int lawyer_id FK
        int user_id FK
        string title
        text description
        string status
        date hearing_date
    }

    INVOICES {
        int id PK
        int appointment_id FK
        decimal amount
        string status
        datetime paid_at
    }

    MESSAGES {
        int id PK
        int sender_id FK
        int receiver_id FK
        text content
        boolean is_read
    }
```

---

## 6. Real-Time Communication Architecture

```mermaid
sequenceDiagram
    participant U1 as User 1
    participant Browser as Browser
    participant Laravel as Laravel App
    participant Pusher as Pusher/Echo
    participant U2Browser as User 2 Browser
    participant U2 as User 2

    U1->>Browser: Send Message
    Browser->>Laravel: POST /chat/send
    Laravel->>Laravel: Save to DB
    Laravel->>Pusher: Broadcast MessageSent Event
    Pusher->>U2Browser: Push Notification
    U2Browser->>U2: Display New Message
    
    Note over Laravel,Pusher: WebSocket Connection
    Note over Pusher,U2Browser: Channel: user.{id}
```

---

## 7. Payment Flow Architecture

```mermaid
flowchart TB
    subgraph User[User]
        U[User Browser]
    end

    subgraph Laravel[Laravel Application]
        PC[PaymentController]
        INV[Invoice Model]
        APT[Appointment Model]
    end

    subgraph SSLCommerz[SSLCommerz Gateway]
        INIT[Initialize Payment]
        PROCESS[Process Payment]
        VALIDATE[Validate Transaction]
    end

    subgraph Callbacks[Payment Callbacks]
        SUCCESS[success_url]
        FAIL[failed_url]
        CANCEL[cancel_url]
        IPN[ipn_url]
    end

    U -->|1. Book Appointment| PC
    PC -->|2. Create Invoice| INV
    PC -->|3. Init Payment| INIT
    INIT -->|4. Redirect| PROCESS
    PROCESS -->|5a. Success| SUCCESS
    PROCESS -->|5b. Failed| FAIL
    PROCESS -->|5c. Cancelled| CANCEL
    PROCESS -->|6. IPN Notification| IPN
    
    SUCCESS --> PC
    FAIL --> PC
    CANCEL --> PC
    IPN --> PC
    
    PC -->|7. Update Status| INV
    PC -->|8. Confirm Booking| APT
    PC -->|9. Redirect| U

    style SSLCommerz fill:#28a745,color:#fff
```

---

## 8. Deployment Architecture

```mermaid
flowchart TB
    subgraph Internet[Internet]
        USERS[Users]
    end

    subgraph LoadBalancer[Load Balancer - Reverse Proxy]
        NGINX[Nginx]
    end

    subgraph AppServers[Application Servers]
        APP1[Laravel Instance 1]
        APP2[Laravel Instance 2]
    end

    subgraph DataServices[Data Services]
        subgraph Primary[Primary]
            MYSQL[(MySQL Primary)]
            REDIS[(Redis Cache)]
        end
        subgraph Replica[Replica]
            MYSQL_R[(MySQL Replica)]
        end
    end

    subgraph Storage[File Storage]
        S3[S3 or Local Storage]
    end

    subgraph Queue[Queue Workers]
        QUEUE[Laravel Queue - Redis/Database]
        WORKER1[Worker 1]
        WORKER2[Worker 2]
    end

    subgraph External[External Services]
        GEMINI[Gemini API]
        SSLC[SSLCommerz]
        PUSHER[Pusher]
        ELASTIC[ElasticSearch]
    end

    USERS --> NGINX
    NGINX --> APP1
    NGINX --> APP2
    
    APP1 --> MYSQL
    APP1 --> REDIS
    APP2 --> MYSQL
    APP2 --> REDIS
    
    MYSQL --> MYSQL_R
    
    APP1 --> S3
    APP2 --> S3
    
    APP1 --> QUEUE
    APP2 --> QUEUE
    QUEUE --> WORKER1
    QUEUE --> WORKER2
    
    APP1 --> External
    APP2 --> External
```

---

## 9. Technology Stack Summary

| Layer | Technology |
|-------|------------|
| **Frontend** | Blade Templates, HTML5, CSS3, JavaScript |
| **Backend Framework** | Laravel 10 (PHP 8.1+) |
| **Database** | MySQL 8.0 |
| **Cache** | File / Redis |
| **Search** | ElasticSearch (Optional) |
| **Real-time** | Pusher / Laravel Echo |
| **AI Integration** | Google Gemini API |
| **Payment Gateway** | SSLCommerz |
| **Metrics** | StatsD (UDP) |
| **Testing** | PHPUnit, PHPStan |
| **CI/CD** | GitHub Actions |

---

## 10. Security Architecture

```mermaid
flowchart TB
    subgraph Security[Security Layers]
        subgraph Network[Network Security]
            HTTPS[HTTPS/TLS]
            CORS[CORS Policy]
            RATE[Rate Limiting]
        end
        
        subgraph App[Application Security]
            CSRF[CSRF Tokens]
            XSS[XSS Protection]
            SQL[SQL Injection Prevention - Eloquent ORM]
            HASH[Password Hashing - bcrypt]
        end
        
        subgraph Auth[Authentication and Authorization]
            SESSION[Session Management]
            ROLES[Role-based Access - user/lawyer/admin]
            MIDDLEWARE[Auth Middleware]
        end
        
        subgraph Data[Data Protection]
            ENCRYPT[AES-256-CBC Encryption]
            VALIDATE[Input Validation]
            SANITIZE[Output Sanitization]
        end
    end

    Network --> App
    App --> Auth
    Auth --> Data
```

---

## Quick Reference: Key Components

| Component | Location | Purpose |
|-----------|----------|---------|
| Routes | `routes/web.php` | Web route definitions |
| Controllers | `app/Http/Controllers/` | Request handling |
| Models | `app/Models/` | Database entities |
| Services | `app/Services/` | Business logic (Gemini, Metrics) |
| Views | `resources/views/` | Blade templates |
| Config | `config/` | App configuration |
| Migrations | `database/migrations/` | Database schema |

---

*Generated for LawLite Legal Platform - January 2026*
