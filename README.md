# Credit Issuance API

A Symfony-based API for managing clients and issuing credits with a Domain-Driven Design approach.

## Requirements
- **PHP:** 8.4
- **Symfony:** 7.2 (latest stable)
- **Docker & Docker Compose**
- **Composer**

## Installation

Follow these steps to get started:

1. **Clone the repository:**
   ```bash
   git clone https://github.com/Santttal/americor_test_case.git
   ```
2. **Change into the project directory:**
   ```bash
   cd americor_test_case
   ```
3. **Build and start the Docker containers:**
   ```bash
   docker-compose up -d
   ```
4. **Install project dependencies:**
   ```bash
   docker-compose exec php composer install
   ```
5. **Run database migrations:**
   ```bash
   docker-compose exec php bin/console doctrine:migrations:migrate
   ```
6. **Load test data using Doctrine Fixtures:**
   ```bash
   docker-compose exec php bin/console doctrine:fixtures:load
   ```

## API Endpoints
### Create Client
- Endpoint: `POST /client/create`
- Request Body:
    ```
    {
      "firstName": "John",
      "lastName": "Doe",
      "age": 30,
      "ssn": "123-45-6789",
      "address": {
        "street": "123 Main St",
        "city": "Los Angeles",
        "state": "CA",
        "zip": "90001"
      },
      "creditRating": 700,
      "email": "john.doe@example.com",
      "phone": "555-1234",
      "monthlyIncome": 3000
    }
    ```
- Note: The client ID is generated on the backend

### Update Client
- Endpoint: `PUT /client/update`
- Request Body:
    ```
    {
      "id": "client-uuid-generated-by-backend",
      "firstName": "John",
      "lastName": "Doe",
      "age": 31,
      "ssn": "123-45-6789",
      "address": {
        "street": "123 Main St",
        "city": "Los Angeles",
        "state": "CA",
        "zip": "90001"
      },
      "creditRating": 710,
      "email": "john.doe@example.com",
      "phone": "555-1234",
      "monthlyIncome": 3200
    }
    ```
### Issue Credit
- Endpoint: `POST /credit/issue`
- Request Body:
```
{
  "clientId": "client-uuid-generated-by-backend",
  "creaditId": "credit-uuid-generated-by-backend",
}
```

## Database Connection
The application connects to a MySQL database with the following parameters:
- Host: 127.0.0.1
- Port: 33306
- Database Name: credit
- Username: root
- Password: password

## Code Quality Tools
### PHP CS Fixer
To automatically fix coding style issues, run:
```
vendor/bin/php-cs-fixer fix
```
### PHPStan
To perform static analysis, run:
```
vendor/bin/phpstan analyse src
```
### Rector
To perform automated code refactoring, run:
```
vendor/bin/rector process src
```
