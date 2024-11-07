# Spy Management API


## Description ##

### This is a simple RESTful API built using Laravel. Its purpose is to manage a system of famous spies.

###

## Prerequisites

- [ ] Docker
- [ ] Docker Compose

###

### Deployment

#### Open a terminal inside the project directory and run:

```
docker compose build
docker compose up
```

### High-Level Architecture Overview

- [ ] Domain-Driven Design (DDD): The project is structured with DDD principles, with clear separation of the Application, Domain, and Infrastructure layers.
  - Application Layer: Contains Commands, Queries, Actions, DTOs, Requests and Resources that encapsulate the main business use cases. This layer is responsible for orchestrating operations without implementing detailed business rules.
  - Domain Layer: Houses core business logic, Models, Value Objects, Enums, Services, Events and Listeners. This layer ensures that the core rules of the spy domain are consistent and isolated from external dependencies.
  - Http Layer: Handling of requests, first-level interaction with the endpoint using controller actions.
  - Infrastructure Layer: Manages persistence, such as repositories for interacting with the database, and any external APIs if needed.

- [ ] CQRS (Command Query Responsibility Segregation): Commands and Queries are separated to differentiate between operations that change state and those that only read data.

- [ ] Event-Driven Architecture: Domain events are dispatched on specific actions like creating a spy. These events are queued and handled asynchronously.

### Structure

#### The project structure is organized as follows:

```
app
├── Application
│   ├── Actions              # Encapsulates main business use cases
│   ├── Commands             # Handles write operations (CQRS)
│   ├── DTOs                 # Defines data structure for each entity
│   ├── Queries              # Handles read operations (CQRS)
│   ├── Requests             # Validates the requests using certain rules
│   └── Resources            # Handles the JSON responses the endpoints return
├── Domain
│   ├── Enums                # Domain-specific Enumerators
│   ├── Events               # Domain events for specific actions
│   ├── Listeners            # Domain event functionality
│   ├── Models               # Domain-specific model entities
│   ├── Services             # Domain-specific functionality
│   └── ValueObjects         # Custom value objects
├── Http
│   └── Controllers          # Handes requests on API endpoints
└── Infrastructure
    └── Repositories         # Persistence layer for data CRUD operations
```

### Core Components

- [ ] Models: Represents the core attributes of a spy and a simple user, encapsulation of value objects where necessary.
- [ ] Validation Requests: Enforcing request field validation rules, ensuring the use of correct request bodies.
- [ ] Value Objects: Used for fields such as FullName and Date, encapsulating field validation and domain-specific rules.
- [ ] Controllers: Including the first-level interaction with the request handling.
- [ ] Action Classes: Encapsulate use cases like creating a spy.

### Application Features

- Spy Creation: Allows authenticated users to create a new spy with fields such as Name, Surname, Agency, Country of Operation, Date of Birth, and optional Date of Death. Validation is applied on both entity and request levels.
- Paginated Spy Listing: Endpoint to list spies with filtering options by age, name, and surname along with multi-field sorting on attributes like full name, date of birth, and date of death.
- List Random Spies: Endpoint to fetch five random spy records, rate-limited for security.

### Testing

The project follows Test-Driven Development (TDD) principles with PHPUnit.
Running Tests

To run the test suite, enter the PHP container using:

```
docker exec -it spy-dev-php-container /bin/bash
```

Then to run the test suite, use:

```php artisan test```

or

```vendor/bin/phpunit```
