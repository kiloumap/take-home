# Foody

### https://localhost

## Architecture
**Exemple  : Hexagonale Architecture  (BC - Bounded Context)**

```
src/
├── RestaurantContext/
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
├── MenuContext/
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
│       └

```

## Definition of Context:
**Context "Restaurant"**
- Gère les fonctionnalités liées aux restaurants, telles que la création, la modification et la suppression des restaurants.
- Gère les opérations métier spécifiques aux restaurants, telles que la gestion des réservations, des avis des clients, etc.
- Fournit des services d'application pour interagir avec les restaurants, tels que la recherche de restaurants, la récupération des détails d'un restaurant, etc.
- Définit les modèles de domaine spécifiques aux restaurants, tels que les entités "Restaurant", "Reservation", "Review", etc.
- Implémente les interfaces de repository pour la persistance des données des restaurants, par exemple en utilisant Doctrine pour la couche d'infrastructure.

**Context "Menu"**
- Gère les fonctionnalités liées aux menus, telles que la création, la modification et la suppression des menus.
- Gère les opérations métier spécifiques aux menus, telles que la gestion des articles de menu, des prix, des promotions, etc.
- Fournit des services d'application pour interagir avec les menus, tels que la récupération des menus disponibles, la mise à jour des articles de menu, etc.
- Définit les modèles de domaine spécifiques aux menus, tels que les entités "Menu", "MenuItem", "Price", etc.
- Implémente les interfaces de repository pour la persistance des données des menus, par exemple en utilisant Doctrine pour la couche d'infrastructure.

