
Register user with role as admin,customer

Customer can create loan, default loan status is pending and repayment schedule is created as per the term selected.

Admin only can approve the loan

Admin can see all loans

Customer can view only there loans

Repayment is made to the scheduled repayments with any amount

If all the repayment completed the repayment and loan status changed to Paid.

**Installation & Run**

composer install

php artisan serve

**Postman collection**
[mini-aspire.postman_collection.json]

**Laravel Passport**

https://laravel.com/docs/9.x/passport

Use Login API to create token and use that token into other API

'Accept' => 'application/json',
'Authorization' => 'Bearer '.$accessToken,

**List of API are created in postman.**


http://localhost:8000/api/register
http://localhost:8000/oauth/token
http://localhost:8000/api/user-detail
http://localhost:8000/api/loans/create?amount=21&term=3
http://localhost:8000/api/loans
http://localhost:8000/api/loans/{loan_id}
http://localhost:8000/api/repay/{loan_repayment_id}

Admin Loan Approve API
http://localhost:8000/api/loans/{loan_id}
http://localhost:8000/api/loans/1


**Demo Customer Users:**

User : customer1@aspireapp.com
Password : aspireapp


User : customer2@aspireapp.com
Password : aspireapp


**Demo Admin Users:**

User : admin@aspireapp.com
Password : aspireapp
