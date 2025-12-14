# Admin Dashboard Fixes - December 14, 2025

## Summary of Issues Fixed

### 1. ✅ Accurate Analytics Data in Admin Dashboard Overview
### 2. ✅ Product Approval Status Display (No approve button for already approved products)
### 3. ✅ Stories Synchronization (Database vs Hardcoded)

---

## Issue 1: Accurate Analytics Data

**Problem:** Revenue calculation in admin dashboard overview was incorrect.

**Root Cause:** Analytics was summing `Order.total_amount` with payment_status filter, but this doesn't accurately reflect actual sales.

**Solution:** 
- Updated `AdminController::getAnalytics()` to calculate revenue from `OrderItem::sum('subtotal')`
- This provides accurate revenue based on actual items sold

**Code Changed:**
```php
// File: app/Http/Controllers/AdminController.php

// Before:
'total_revenue' => Order::where('payment_status', 'paid')->sum('total_amount') ?? 0,
'revenue_this_month' => Order::whereMonth('created_at', now()->month)
    ->where('payment_status', 'paid')
    ->sum('total_amount') ?? 0,

// After:
'total_revenue' => OrderItem::sum('subtotal') ?? 0,
'revenue_this_month' => OrderItem::whereHas('order', function($q) {
    $q->whereMonth('created_at', now()->month);
})->sum('subtotal') ?? 0,
```

---

## Issue 2: Product Approval Status Display

**Problem:** In the Product Management tab, approved products still displayed an "Approve" button, allowing admins to approve them multiple times.

**Expected Behavior:** 
- Approved products should show "✓ Approved" label
- Only pending products should show "Approve" and "Reject" buttons

**Solution:**
- Updated product card rendering to conditionally show buttons based on `approval_status`
- Added visual color coding for different statuses
- Added `rejectProduct()` function for handling rejections

**Code Changed:**
```javascript
// File: resources/views/admin/dashboard.blade.php

grid.innerHTML = products.map(product => `
    <div class="bg-white rounded-lg shadow p-4">
        ...
        <p class="text-gray-500 mt-1 text-sm">Status: 
            <span class="font-medium capitalize ${
                product.approval_status === 'approved' ? 'text-green-600' : 
                product.approval_status === 'pending' ? 'text-yellow-600' : 
                'text-red-600'
            }">${product.approval_status}</span>
        </p>
        
        <div class="flex gap-2 mt-3">
            ${product.approval_status === 'approved' 
                ? `<span class="flex-1 text-center py-2 px-3 bg-green-50 text-green-700 rounded text-sm font-medium">✓ Approved</span>` 
                : `<button onclick="approveProduct(${product.id})">Approve</button>
                   <button onclick="rejectProduct(${product.id})">Reject</button>`
            }
            <button onclick="deleteProduct(${product.id})">Delete</button>
        </div>
    </div>
`).join('');
```

**New Function Added:**
```javascript
function rejectProduct(productId) {
    if (!confirm('Reject this product?')) return;
    
    fetch(`/admin/api/products/${productId}/status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ approval_status: 'rejected' })
    }).then(res => res.json()).then(data => {
        if (data.success) {
            alert('Product rejected!');
            loadProducts();
            loadAnalytics();
        }
    });
}
```

---

## Issue 3: Stories Not Showing in Admin Dashboard

**Problem:** The hero page had 3 hardcoded stories that appeared in the "Stories of Heritage" section, but these stories weren't in the database, so they didn't show up in the admin dashboard Stories tab.

**Root Cause:**
- Stories were hardcoded in `resources/views/components/stories-section.blade.php`
- Stories were also hardcoded in `resources/views/layouts/app.blade.php` for modal content
- Database was empty, so admin dashboard showed no stories

**Solution:**
1. Created database seeder to insert the 3 hardcoded stories
2. Updated hero page to load stories from database via API
3. Copied story images to proper directory

**Steps Taken:**

**Step 1:** Created seeder
```php
// File: database/seeders/HeroStoriesSeeder.php
// Inserted 3 stories with full content into database
```

**Step 2:** Copied images
```bash
# Copied story images from /assets/artisans/ to /assets/stories/
Amparo-Balansi-Mabanag.jpg
Eduardo-Mutuc.jpg  
Magdalena-Gamayo.jpeg
```

**Step 3:** Updated hero page component
```javascript
// File: resources/views/components/stories-section.blade.php

// Before: Hardcoded PHP array
@php
$stories = [
    ['title' => 'Preserving T\'nalak Traditions', ...],
    ...
];
@endphp

// After: Load from API
<div id="hero-stories-grid">
    <!-- Loading indicator -->
</div>

<script>
async function loadHeroStories() {
    const response = await fetch('/api/public/stories');
    const stories = await response.json();
    // Render stories dynamically
}
</script>
```

**Step 4:** Ran seeder
```bash
php artisan db:seed --class=HeroStoriesSeeder
# Result: Hero stories seeded successfully!
```

**Stories Added:**
1. **"Preserving T'nalak Traditions"** - Amparo Balansi Mabanag (T'boli tribe)
2. **"The Art of Metal Smithing"** - Eduardo Mutuc (Ifugao tribe)  
3. **"Weaving Community Together"** - Magdalena Gamayo (Ilocano tribe)

---

## Testing Instructions

### Test 1: Admin Analytics
1. Login as admin
2. Navigate to Overview tab
3. Verify revenue displays correct amount
4. Check that pending sellers/products counts are accurate

### Test 2: Product Approval UI
1. As seller: Create a new product
2. As admin: Navigate to Products tab
3. Verify pending product shows "Approve" and "Reject" buttons
4. Click "Approve"
5. Refresh and verify product shows "✓ Approved" badge (no approve button)
6. Logout and check shop page - product should appear

### Test 3: Stories Synchronization
1. Login as admin
2. Go to Stories tab
3. Verify 3 stories appear: T'nalak, Metal Smithing, Weaving Community
4. Logout
5. Visit homepage and scroll to "Stories of Heritage"
6. Verify same 3 stories appear
7. Click "Read More" on any story - modal should open with full content
8. Visit /stories page - stories should load from database

---

## Files Modified

1. **app/Http/Controllers/AdminController.php**
   - Fixed revenue calculation in `getAnalytics()` method

2. **resources/views/admin/dashboard.blade.php**
   - Updated product card rendering logic
   - Added `rejectProduct()` function
   - Added status color coding

3. **resources/views/components/stories-section.blade.php**
   - Replaced hardcoded stories with API-based loading
   - Added JavaScript to fetch and render stories dynamically

4. **database/seeders/HeroStoriesSeeder.php** (NEW)
   - Created seeder for 3 hero page stories

5. **public/assets/stories/** (IMAGES ADDED)
   - Amparo-Balansi-Mabanag.jpg
   - Eduardo-Mutuc.jpg
   - Magdalena-Gamayo.jpeg

---

## Benefits Achieved

✅ **Accurate Data** - Revenue and analytics show real values from OrderItems
✅ **Better UX** - Clear visual indication of product status, no duplicate approvals
✅ **Data Consistency** - Stories appear identically across admin and public pages
✅ **Centralized Management** - All stories managed through admin dashboard
✅ **Database-Driven** - No more hardcoded content, easier to maintain and scale
