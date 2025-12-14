# Complete Data Flow Diagram

```
┌─────────────────────────────────────────────────────────────────────────────┐
│                           BALANGAY WORKFLOW SYSTEM                            │
└─────────────────────────────────────────────────────────────────────────────┘

┌──────────────────────────────────────────────────────────────────────────────┐
│                              1. PRODUCTS FLOW                                 │
└──────────────────────────────────────────────────────────────────────────────┘

  SELLER SIDE                    ADMIN SIDE                    PUBLIC SIDE
  ───────────                    ──────────                    ───────────

┌─────────────┐              ┌──────────────┐              ┌─────────────┐
│   Seller    │              │    Admin     │              │   Public    │
│  Dashboard  │              │  Dashboard   │              │  Shop Page  │
└──────┬──────┘              └──────┬───────┘              └──────┬──────┘
       │                             │                             │
       │ 1. Create Product           │                             │
       │    approval_status:         │                             │
       │    'pending'                │                             │
       │                             │                             │
       ▼                             │                             │
┌─────────────────┐                 │                             │
│   DATABASE      │                 │                             │
│   products      │                 │                             │
│   approval_     │                 │                             │
│   status:       │◄────────────────┤ 2. View Pending             │
│   'pending'     │                 │    Products                 │
└─────────────────┘                 │                             │
       │                            │                             │
       │                            │ 3. Approve Product          │
       │                            │    (Change status to        │
       │                            │     'approved')             │
       │                            │                             │
       ▼                            ▼                             │
┌─────────────────┐          ┌─────────────┐                     │
│   DATABASE      │          │  Admin API  │                     │
│   products      │          │  /admin/api/│                     │
│   approval_     │          │  products/  │                     │
│   status:       │          │  {id}/status│                     │
│   'approved'    │          └─────────────┘                     │
└────────┬────────┘                                               │
         │                                                        │
         │                                                        │
         │                            4. Load Approved Products  │
         │                               /api/products/search    │
         │                               WHERE approval_status   │
         │                               = 'approved'            │
         │                                                        │
         └────────────────────────────────────────────────────────►
                                                            ┌─────────────┐
                                                            │   PUBLIC    │
                                                            │  SEES THE   │
                                                            │  PRODUCT    │
                                                            └─────────────┘

┌──────────────────────────────────────────────────────────────────────────────┐
│                              2. STORIES FLOW                                  │
└──────────────────────────────────────────────────────────────────────────────┘

  ADMIN SIDE                                              PUBLIC SIDE
  ──────────                                              ───────────

┌──────────────┐                                        ┌──────────────┐
│    Admin     │                                        │   Public     │
│  Dashboard   │                                        │ Stories Page │
│ Stories Tab  │                                        └──────┬───────┘
└──────┬───────┘                                               │
       │                                                       │
       │ 1. Create Story                                      │
       │    published: false                                  │
       │                                                       │
       ▼                                                       │
┌─────────────────┐                                           │
│   DATABASE      │                                           │
│   stories       │                                           │
│   published:    │                                           │
│   false         │                                           │
└─────────────────┘                                           │
       │                                                      │
       │ 2. Toggle Published                                 │
       │    published: true                                  │
       │                                                      │
       ▼                                                      │
┌─────────────────┐                                           │
│   DATABASE      │                                           │
│   stories       │                                           │
│   published:    │                                           │
│   true          │                                           │
└────────┬────────┘                                           │
         │                                                    │
         │                     3. Load Published Stories      │
         │                        /api/public/stories         │
         │                        WHERE published = true      │
         │                                                    │
         └────────────────────────────────────────────────────►
                                                        ┌─────────────┐
                                                        │   PUBLIC    │
                                                        │  SEES THE   │
                                                        │   STORY     │
                                                        └─────────────┘

┌──────────────────────────────────────────────────────────────────────────────┐
│                        3. FEATURED ARTISTS FLOW                               │
└──────────────────────────────────────────────────────────────────────────────┘

  ADMIN SIDE                                              PUBLIC SIDE
  ──────────                                              ───────────

┌──────────────┐                                        ┌──────────────┐
│    Admin     │                                        │   Public     │
│  Dashboard   │                                        │  Homepage    │
│ Artists Tab  │                                        │  (Future)    │
└──────┬───────┘                                        └──────┬───────┘
       │                                                       │
       │ 1. Create Featured Artist                            │
       │    active: false                                     │
       │                                                       │
       ▼                                                       │
┌─────────────────┐                                           │
│   DATABASE      │                                           │
│ featured_       │                                           │
│ artists         │                                           │
│ active: false   │                                           │
└─────────────────┘                                           │
       │                                                      │
       │ 2. Toggle Active                                    │
       │    active: true                                     │
       │                                                      │
       ▼                                                      │
┌─────────────────┐                                           │
│   DATABASE      │                                           │
│ featured_       │                                           │
│ artists         │                                           │
│ active: true    │                                           │
└────────┬────────┘                                           │
         │                                                    │
         │              3. Load Active Featured Artists       │
         │                 /api/public/featured-artists       │
         │                 WHERE active = true                │
         │                                                    │
         └────────────────────────────────────────────────────►
                                                        ┌─────────────┐
                                                        │   PUBLIC    │
                                                        │  SEES THE   │
                                                        │   ARTIST    │
                                                        └─────────────┘

┌──────────────────────────────────────────────────────────────────────────────┐
│                          API ENDPOINTS REFERENCE                              │
└──────────────────────────────────────────────────────────────────────────────┘

PUBLIC APIs (No Auth Required)
─────────────────────────────
GET  /api/products/search           → Approved products only
GET  /api/public/stories            → Published stories only
GET  /api/public/featured-artists   → Active featured artists only

ADMIN APIs (auth:admin Middleware)
──────────────────────────────────
GET    /admin/api/products                → All products with filters
PUT    /admin/api/products/{id}/status    → Approve/Reject products
GET    /admin/api/stories                 → All stories
POST   /admin/api/stories                 → Create story
PUT    /admin/api/stories/{id}            → Update story (toggle publish)
DELETE /admin/api/stories/{id}            → Delete story
GET    /admin/api/featured-artists        → All featured artists
POST   /admin/api/featured-artists        → Create featured artist
PUT    /admin/api/featured-artists/{id}   → Update (toggle active)
DELETE /admin/api/featured-artists/{id}   → Delete featured artist

SELLER APIs (auth:seller Middleware)
────────────────────────────────────
POST   /seller/api/products        → Create product (status='pending')
PUT    /seller/api/products/{id}   → Update product
DELETE /seller/api/products/{id}   → Delete product

┌──────────────────────────────────────────────────────────────────────────────┐
│                          AUTHENTICATION GUARDS                                │
└──────────────────────────────────────────────────────────────────────────────┘

web     → Regular users (customers)
seller  → Sellers (artisans/vendors)
admin   → Administrators

Each guard has separate authentication session and middleware protection.
```
