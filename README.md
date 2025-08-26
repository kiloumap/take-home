# Take-Home

### https://localhost

## Architecture

**Hexagonale Architecture (BC - Bounded Context)**

I prefer work in Hexagonale architecture to have a good split between context.

##### /!\ Disclaimer: I used an old boilerplate I made almost 3 years ago, including docker, symfony configured in hexagonal etc...

_That was a good opportunity to update php 8.2 => 8.4, symfony 6.3 => 7.3..._

## How to:

#### If you have justfile locally installed

1. `just build`
2. `just init-db`
3. `just migrate`

#### Withou Justfile

1. `docker-compose build`
2. `docker-compose exec php php bin/console doctrine:database:create`
3. `docker-compose run --rm php bin/console doctrine:migrations:migrate --no-interaction`

#### Tests
`just run-test`
`docker-compose run --rm php bin/phpunit --coverage-html coverage`
`docker-compose run --rm php bin/phpunit --coverage-text`

## API Endpoint

Except `api/register` and `api/login`, all the routes are protected with a JWT token.

| Header          | Value            |
|-----------------|------------------|
| `Authorization` | `Bearer [token]` |

| Method | Endpoint                            | Description                 | Payload                                                                                                                                                                                                                 |
|--------|-------------------------------------|-----------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| POST   | `/api/register`                     | Create a new user           | `{"email": "doe@gmail.com,  "password: "PwdSuperSecure"}`                                                                                                                                                               |
| POST   | `/api/login`                        | Login                       | `{"username": "doe@gmail.com,  "password: "PwdSuperSecure"}`                                                                                                                                                            |
| POST   | `/api/product/add`                  | Add a new product           | `{"name": "PhpStorm", "description": "IDE for PHP by JetBrains", "pricingOption": [ {"name": "Monthly", "price": 29.99, "billingPeriod": "monthly"},  {"name": "Yearly", "price": 299.99, "billingPeriod": "yearly"}]}` |
| POST   | `/api/subscription/subscribe`       | Subscribe user to a product | `{"productName": "PhpStorm","pricingOptionName": "Monthly"} `                                                                                                                                                           |
| DELETE | `/api/subscription/cancel`          | Cancel subscription         | `{"productName": "PhpStorm"}`                                                                                                                                                                                           |
| GET    | `/api/users/subscription/subscribe` | List active subscriptions   | `N\A`                                                                                                                                                                                                                   |

## Context:

The system should be able to:

- Add users and products
- Subscribe a user to a product
- Cancel a subscription
- List all active subscriptions for a given user

I decided to have 3 contexts + 1 shared, see bellow

```
src/
├── Product/
│   ├── Application/
│   │   ├── Controller/
│   │   └── Request/
│   ├── Domain/
│   │   ├── Enum/
│   │   ├── Model/
│   │   ├── Repository/
│   │   └── Service/
│   └── Infrastructure/
│       ├── Exception/
│       └── Persistence/
│           └── Doctrine/
│               ├── Mapping
│               ├── Repository
│               └── Type
├── Shared/
│   ├── Domain/
│   │   └── ValueObject/
│   └── Infrastructure/
│       └── Persistence/
│           ├── Doctrine/
│           │   ├── Migrations
│           │   └── Type
│           ├── InMemory/
│           └── Security
├── Subscription/
│   ├── Application/
│   │   ├── Controller/
│   │   └── Request/
│   ├── Domain/
│   │   ├── Exception/
│   │   ├── Model/
│   │   ├── Repository/
│   │   └── Service/
│   └── Infrastructure/
│       └── Persistence/
│           └── Doctrine/
│               ├── Mapping
│               └── Repository
├── User/
│   ├── Application/
│   │   ├── Request/
│   │   └── Controller/
│   ├── Domain/
│   │   ├── Model/
│   │   ├── Repository/
│   │   └── Service/
│   └── Infrastructure/
│       └── Persistence/
│        │  └── Doctrine/
│        │  │   ├── Mapping
│        │  │   └── Migrations
│        └── Security
```

### AI Usage:

mainly use AI in PhpStorm with GitHub Copilot to improve auto-completion and generate accessors, XML files, and similar boilerplate.
I also used Claude AI to fix some issues after upgrading versions, but since it is not up to date with the latest PHP and Symfony releases, it failed in some cases.
I occasionally used it to get quick help on GitHub CI.
Finally, I asked Claude AI about new features in Symfony, such as `#[MapRequestPayload]` or updates in the `security` component, since I had not worked with Symfony since version 5.4.

### Code Coverage
I ran some quick tests, mainly on the services.
Those can easily reach 100% coverage, while the overall codebase sits at around 50%.
I also decided to use only in-memory persistence, whereas I would normally use an actual database to fully test persistence.
They can be ran with
`just run-test`
or
`docker-compose run --rm php bin/phpunit --coverage-html coverage`
![img.png](img.png)