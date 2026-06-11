# Shopping Cart Checkout Flow Implementation Guide

## Overview
This document describes the complete shopping cart checkout flow that has been implemented for the Funshirt application.

## Implementation Summary

### Components Created

#### 1. **CheckoutController** (`app/Http/Controllers/CheckoutController.php`)
- **Purpose**: Handles all checkout operations
- **Methods**:
  - `show()`: Displays the checkout form with validation checks
  - `store()`: Processes the checkout and creates the order

**Validation Flow:**
1. Checks user authentication (enforced by route middleware)
2. Verifies customer record exists
3. Verifies customer has a billing address configured
4. Validates cart is not empty
5. Validates payment method form input

**Error Handling:**
- Unauthenticated users → redirect to login
- Missing customer record → redirect to profile settings
- Missing address → redirect to address settings
- Empty cart → redirect to cart view with warning

#### 2. **OrderCheckoutNotification** (`app/Notifications/OrderCheckoutNotification.php`)
- **Purpose**: Sends order confirmation email via Mailtrip
- **Features**:
  - Queued for async processing
  - Sends formatted email with order details
  - Includes all order items with colors and sizes
  - Displays payment method and shipping address
  - Shows optional notes

#### 3. **Checkout View** (`resources/views/shop/checkout.blade.php`)
- **Features**:
  - Displays customer information (read-only, with edit link)
  - Shows shipping address with edit link
  - Payment method selection (3 options)
  - Optional bank transfer reference field
  - Order notes field
  - Order summary sidebar with item list and total

#### 4. **Updated Cart View** (`resources/views/shop/cart.blade.php`)
- Changed checkout button from placeholder `#` to `route('checkout.show')`
- Authentication check remains: unauthenticated users see "Login to Checkout"

#### 5. **Routes** (`routes/web.php`)
- Added checkout route group with auth + verified middleware
  - `GET /checkout` → Shows checkout form
  - `POST /checkout` → Processes checkout

---

## Checkout Flow Diagram

```
User adds items to cart
        ↓
User clicks "Checkout" button
        ↓
[Auth Check] ← Route middleware (auth, verified)
        ↓
[Customer Record Check]
   ├─ Missing? → Redirect to Profile Settings
   └─ Exists? → Continue
        ↓
[Address Check]
   ├─ Missing? → Redirect to Address Settings
   └─ Exists? → Show checkout form
        ↓
User selects payment method
   ├─ Card → No additional fields
   ├─ Bank Transfer → Show reference field
   └─ Cash on Delivery → No additional fields
        ↓
User adds optional notes
        ↓
User clicks "Complete Order"
        ↓
[Form Validation]
   ├─ Invalid → Show errors
   └─ Valid → Continue
        ↓
[Create Order Record]
   ├─ customer_id: from authenticated user
   ├─ status: "pending"
   ├─ total_price: calculated from cart
   ├─ nif: from customer record
   ├─ address: from customer record
   └─ payment_type: from form
        ↓
[Create OrderItem Records]
   ├─ For each cart item
   ├─ Store: tshirt_image_id, color, size, qty, price
   └─ Calculate sub_total
        ↓
[Send Confirmation Email]
   ├─ Via Mailtrip (configured in .env)
   ├─ Queued for async processing
   └─ Includes order details, items, address, payment info
        ↓
[Clear Cart]
        ↓
[Redirect to Home]
        ↓
Display success message
```

---

## Testing Checklist

### 1. **Unauthenticated User Flow**
- [ ] Add items to cart
- [ ] Navigate to checkout without logging in
- [ ] Should redirect to login page
- [ ] After login, checkout should work normally

### 2. **Missing Customer Record**
- [ ] Create a new user account (if doesn't have customer record)
- [ ] Try to checkout
- [ ] Should redirect to profile settings
- [ ] Configure profile and address
- [ ] Checkout should then work

### 3. **Missing Address**
- [ ] Login with an account that has customer record but no address
- [ ] Try to checkout
- [ ] Should redirect to address settings
- [ ] Configure address
- [ ] Checkout should work

### 4. **Checkout Display**
- [ ] Verify customer information displays correctly
- [ ] Verify shipping address displays correctly
- [ ] Verify order summary shows all items
- [ ] Verify total price is calculated correctly

### 5. **Payment Method Selection**
- [ ] Select "Credit/Debit Card" → no additional fields shown
- [ ] Select "Bank Transfer" → reference field should appear
- [ ] Select "Cash on Delivery" → reference field should disappear

### 6. **Order Creation**
- [ ] Submit checkout form with all required fields
- [ ] Verify order is created in database
  - Check `orders` table for new record
  - Check `order_items` table for items
- [ ] Verify order total matches cart total
- [ ] Verify cart is cleared (session)

### 7. **Email Confirmation**
- [ ] Check Mailtrip for received email
- [ ] Verify email includes:
  - [ ] Order ID
  - [ ] Order date
  - [ ] Total price
  - [ ] Order status (pending)
  - [ ] Item details (name, size, color, quantity, price)
  - [ ] Shipping address
  - [ ] Payment method
  - [ ] Any notes provided

### 8. **Error Handling**
- [ ] Submit form without selecting payment method
  - Should show validation error
  - Form should not submit
- [ ] Go back and modify cart while in checkout
  - Should update cart correctly
- [ ] Attempt to checkout with empty cart
  - Should redirect with warning message

### 9. **Cart Modifications**
- [ ] Add items to cart
- [ ] Go to checkout
- [ ] Modify item quantity in cart (using browser back button)
- [ ] Return to checkout
- [ ] Verify checkout reflects updated cart

### 10. **User Flow Completeness**
- [ ] Complete full checkout flow from cart to confirmation
- [ ] Verify user is redirected to home page with success message
- [ ] Verify user receives confirmation email

---

## Configuration Required

### Email Configuration (.env)
The checkout uses the existing Mailtrip configuration:

```env
MAIL_MAILER=smtp
MAIL_HOST={mailtrip_host}
MAIL_PORT=2525
MAIL_USERNAME={mailtrip_username}
MAIL_PASSWORD={mailtrip_password}
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@funshirt.com
MAIL_FROM_NAME="Funshirt"
```

### Queue Configuration
For production, ensure queue processing is set up:
```bash
php artisan queue:work
```

In development, you can use sync queue:
```env
QUEUE_CONNECTION=sync
```

---

## Database Schema

The implementation uses existing models:

### Orders Table
```
- id
- customer_id (FK to customers)
- status (pending/completed/cancelled)
- date
- total_price
- notes
- reason_for_cancellation
- nif
- address
- payment_type (card/bank_transfer/cash)
- payment_ref (optional)
- receipt_url (optional)
- created_at / updated_at
```

### Order Items Table
```
- id
- order_id (FK to orders)
- tshirt_image_id (FK to tshirt_images)
- color_code (FK to colors)
- size (XS/S/M/L/XL)
- qty
- unit_price
- sub_total
```

---

## API Routes

### Checkout Routes
```
GET  /checkout              - Show checkout form (auth, verified)
POST /checkout              - Process checkout (auth, verified)
```

---

## Notes

1. **Queue Processing**: Emails are queued using Laravel's Queueable interface. In development, use `QUEUE_CONNECTION=sync` to process immediately.

2. **Authentication**: All checkout routes require both authentication AND email verification.

3. **Address Required**: Users must configure their billing address before checkout. This is enforced at both the controller and UI level.

4. **Cart Session**: Cart is stored in session and is cleared only after successful order creation.

5. **Customer Record**: The Customer model uses User ID as its primary key, creating a one-to-one relationship.

6. **Error Messages**: All redirects include contextual error/warning messages using the alert system.

7. **Customized Items**: The order items can include both catalog items and personalized tshirts (indicated by `customer_id` on tshirt_images).

---

## Future Enhancements

- [ ] Add order tracking page
- [ ] Implement payment gateway integration
- [ ] Add invoice PDF generation and email attachment
- [ ] Implement order history and management
- [ ] Add email notifications for order status changes
- [ ] Implement refund/cancellation process with status updates
- [ ] Add admin order management dashboard

