# MindHeaven Database Schema Documentation

## Overview
The MindHeaven database schema is designed to support a comprehensive mental health platform for university students. It follows a modular approach with clear separation of concerns and proper normalization.

## Database Architecture

### 1. User Management Layer
- **users**: Central authentication and basic user information
- **undergraduate_students**: Extended profile for student users
- **counselors**: Professional mental health provider profiles
- **university_representatives**: University staff and administrators

### 2. Forum System
- **forum_categories**: Discussion categories for organized conversations
- **forum_threads**: Discussion topics and initial posts
- **forum_posts**: Replies and comments on threads
- **forum_moderation_log**: Audit trail for moderation actions

### 3. Mood Tracking System
- **mood_records**: Daily mood tracking with detailed metrics
- Supports mood levels (1-10), types, triggers, and coping strategies
- Includes sleep, exercise, and social interaction tracking

### 4. Appointment & Booking System
- **appointments**: Counseling session bookings and management
- **counselor_availability**: Counselor scheduling and availability
- Supports multiple appointment types and locations

### 5. Resource Management
- **resource_categories**: Organization of educational materials
- **resources**: File uploads and educational content
- Includes approval workflow and usage tracking

### 6. Feedback & Crisis Management
- **feedback**: User complaints, suggestions, and bug reports
- **crisis_calls**: Emergency crisis intervention records
- **crisis_response_log**: Detailed response tracking and outcomes

### 7. Donation System
- **donations**: Financial contributions and payment tracking
- Links to events and supports anonymous donations
- Includes payment method and status tracking

### 8. Event Management
- **events**: Workshops, seminars, and awareness campaigns
- **event_participants**: Registration and attendance tracking
- **event_proof_uploads**: Documentation and proof of participation

### 9. University Integration
- **universities**: Institution information and customization
- **university_representatives**: University staff management
- Supports multi-university deployments

### 10. Supporting Systems
- **user_sessions**: Active session management and security
- **system_settings**: Configurable platform settings

## Key Features

### Security & Privacy
- Encrypted password storage
- Session management with expiration
- Role-based access control
- Audit trails for sensitive operations

### Scalability
- Proper indexing for performance
- Normalized structure to reduce redundancy
- Foreign key constraints for data integrity
- Triggers for automatic updates

### Flexibility
- Configurable system settings
- Multi-university support
- Extensible user roles
- Customizable resource categories

## Table Relationships

### Core User Flow
```
users (1) ←→ (1) undergraduate_students
users (1) ←→ (1) counselors
users (1) ←→ (1) university_representatives
```

### Forum System
```
forum_categories (1) ←→ (many) forum_threads
forum_threads (1) ←→ (many) forum_posts
users (1) ←→ (many) forum_threads
users (1) ←→ (many) forum_posts
```

### Appointment System
```
undergraduate_students (1) ←→ (many) appointments
counselors (1) ←→ (many) appointments
counselors (1) ←→ (many) counselor_availability
```

### Crisis Management
```
users (1) ←→ (many) crisis_calls
users (1) ←→ (many) crisis_response_log
crisis_calls (1) ←→ (many) crisis_response_log
```

### Event System
```
events (1) ←→ (many) event_participants
events (1) ←→ (many) event_proof_uploads
users (1) ←→ (many) event_participants
```

## Data Types & Constraints

### Common Patterns
- **IDs**: UNSIGNED INT AUTO_INCREMENT PRIMARY KEY
- **Timestamps**: DATETIME with DEFAULT CURRENT_TIMESTAMP
- **Status Fields**: ENUM with appropriate values
- **Text Fields**: TEXT for longer content, VARCHAR for shorter
- **Boolean Fields**: TINYINT(1) with DEFAULT values

### Security Considerations
- Password hashing (VARCHAR(255) for bcrypt/Argon2)
- Session tokens (VARCHAR(255) UNIQUE)
- IP address storage (VARCHAR(45) for IPv6 support)
- Input validation through CHECK constraints

## Indexing Strategy

### Performance Indexes
- Primary keys on all tables
- Foreign key indexes for joins
- Status and type indexes for filtering
- Date/time indexes for sorting and range queries
- Unique indexes for business constraints

### Query Optimization
- Composite indexes for common query patterns
- Covering indexes for frequently accessed data
- Partial indexes for filtered queries

## Sample Data

The schema includes sample data for:
- University information
- Forum categories
- Resource categories
- System settings

## Maintenance & Monitoring

### Triggers
- Automatic thread statistics updates
- Event participant count management
- Timestamp updates on record modifications

### Constraints
- Foreign key constraints for referential integrity
- Check constraints for data validation
- Unique constraints for business rules

## Future Enhancements

### Potential Additions
- Notification system tables
- Analytics and reporting tables
- Integration with external systems
- Advanced search capabilities
- Real-time messaging system

### Scalability Considerations
- Partitioning for large tables
- Read replicas for reporting
- Caching strategies
- API rate limiting

## Usage Guidelines

### Best Practices
1. Always use transactions for multi-table operations
2. Implement proper error handling
3. Use prepared statements for security
4. Regular backup and maintenance
5. Monitor query performance
6. Keep indexes updated

### Common Queries
- User authentication and session management
- Forum post retrieval with pagination
- Appointment scheduling and availability
- Crisis call routing and assignment
- Resource search and filtering
- Event registration and management

This schema provides a solid foundation for a comprehensive mental health platform while maintaining flexibility for future enhancements and scalability requirements.

