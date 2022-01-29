## Installation
1. install composer
2. setup database credentials in .env file
3. run command  php artisan serve
4. after that open url in browser your_url/setup  for example

http://127.0.0.1:8000/setup
<p>It will setup all project requirements</p>

###Test credential for admin
<b>Username:</b>admin@gmail.com <br />
<b>Password:</b>123456

###Test credential for customer
<b>Username:</b>customer@gmail.com <br />
<b>Password:</b>123456



##Postman collection
example {{base_url}} = http://127.0.0.1:8000/api  use your url/api
####For login
{{base_url}}/login



##Customer API collection

####Register new customer
{{base_url}}/register-customer


####Apply for loan 
<p>Use token of customer</p>
{{base_url}}/loan-apply

###Check loan status
<p>Use token of customer</p>
{{base_url}}/loan-status

####Loan Repayment
<p>Use token of customer</p>
{{base_url}}/loan-pay
<br />

##Admin API Collection

####Loan approve
<p>Use token of admin</p>
{{base_url}}/admin/loan-approve


####Loan detail
<p>Use token of admin</p>
{{base_url}}/admin/loan-detail

