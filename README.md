# Take-Home

### https://localhost

## Architecture
**Hexagonale Architecture (BC - Bounded Context)**

```
src/
├── Default/
│   ├── Application/
│   │   ├── Command/
│   │   ├── Query/
│   │   └── Controller/
│   ├── Domain/
│   │   ├── Model/
│   │   ├── Repository/
│   │   ├── Service/
│   │   └── Port/
│   └── Infrastructure/
│       ├── Persistence/
│       └── Doctrine/
├── Shared/
│   ├── Application/
│   │   ├── Command/
│   │   └── Controller/
│   ├── Domain/
│   │   └── ValueObject/
│   └── Infrastructure/
│       └── Persistence/
│           ├── DoctrineMigrations/
│           ├── Doctrine/
│           │   ├── Mapping
│           │   └── Type
│           ├── InMemory/
│           └── Security
├── User/
│   ├── Application/
│   │   ├── Command/
│   │   ├── Request/
│   │   └── Controller/
│   ├── Domain/
│   │   ├── Model/
│   │   ├── Repository/
│   │   └── Service/
│   └── Infrastructure/
│       └── Persistence/
│           ├── DoctrineMigrations/
│           └── Doctrine/
│           │   └── Mapping
│           └── Security
```
