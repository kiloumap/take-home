# Foody

### https://localhost

## Architecture
**Exemple  : Hexagonale Architecture  (BC - Bounded Context)**

```
src/
├── DdefaultContext/
│   ├── Application/
│   │   ├── Command/
│   │   ├── Query/
│   │   ├── Service/
│   │   └── ...
│   ├── Domain/
│   │   ├── Model/
│   │   ├── Repository/
│   │   ├── Service/
│   │   ├── Port/
│   │   └── ...
│   └── Infrastructure/
│       ├── Persistence/
│       │   ├── Doctrine/
│       │   └── ...
│       ├── Messaging/
│       │   ├── RabbitMQ/
│       │   └── ...
│       └── ...
```
