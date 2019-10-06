# Chemsitry Repair Ticketing System

This was a project done by a team of 5 for our CISC 498 course at Queen's 
University. Our job was to create a real product for a real client. 

We chose to create an online repair ticketing system for the Queen's Chemistry
department. This system was made to replace the pen and paper system they currently
had in place for ticketing repairs. The old system had no way of informing users
of current statuses, contacting them for more information, or creating an easy way
to archive repairs. This new system hopes to solve those problems while also
making it more accessible to users and admins (techs)

We used an html and css front end, with bootrap 4 for styling. Our server was
written in PHP and used a mySQL database. 

## Documentation

All documentation is in the "Manuals & Supporting Documentation" folder.

## Usage

Below are screnshots of the usage the ticketing system has. 

A feature that exists, but cannot be shown, is that users and admins get email 
notifications when certain actions occur. These actions might be something like a
change in ticket status, or a chat message arriving. 

### Admin Usage
There are 2 types of accounts. Admins and Users. Admins are the people who will
be reading the tickets and making the repairs. They are also refered to as techs.

Users that are not already logged in will first see this page. They have the 
ability to log in, or contact the Chemistry department if they have forgotten 
their password or need an account.
![Log in Page](/assets/loginPage.png)

If an admin logs in, they are
initially taken to this page. This is a list of all tickets. From this page the
admins are also able to edit some of the information a user entered. This is 
required in case the user enters some incorrect information.
![Admin Ticket List](/assets/adminTicketList.png)

This list of tickets can also be filtered by the filter fields at the top left
of the page. If the admin is looking for a specific ticket that was made by 
Marie Curie about a machine in room "301", they would see this.
![Filtered Admin Ticket List](/assets/filteredAdminTicketList.png)

The admin can also create an invoice for a specific ticket. They can enter which
items were used for the repair, and how much they cost. This information is then
saved for future use.
![Invoice Page](/assets/invoicePage.png)

From the invoice page, the admin can save the invoice as a PDF file and download
it. They can then send this pdf invoice to their finance department or just save
it somewhere.
![Invoice PDF](/assets/pdfInvoice.png)

There is also a communication feature between admins and users. They can communicate
through a ticket so that if there is any information that was missed, the admin
can contact the user about it. 

Along with the communication feature, if the Admin pressed the "Send Invoice to User"
button, a copy of the invoice would be sent to the user so they can look over it
and get approval from their supervisor for the repair if needed.
![Admin Chat Feature and Send PDF Invoice](/assets/adminChat.png)

Admins can also view a page full of charts and graphs so they can easily see what
is going on with the tickets. They can see information like how many tickets each
admin has assigned to them, how many tickets are unassigned, how many tickets come 
in each week, or month, which rooms break the most machines, and which machines 
break most often.
![Chart Page](/assets/chartPage.png)

### User Usage
Users are the end users. They are the people that will be submitting tickets for
broken machines.

The user can see a list of tickets that they have submitted for repairs. This list
only shows ticket they have submitted and does not allow for editting info. The
filter functionality is very similar too, however some features have been removed 
because they are admin only features.
![User Ticket List](/assets/userTicketList.png)

The user can still access messages and can chat with the admins in charge of their
ticket. They can also see any invoices the admins sent to the user.
![User Chat](/assets/userChat.png)

To create a new ticket, the user must go to the "Create Ticket" tab at the top 
right of the screen. Here they can enter all the information about a repair that 
needs to be done. This information is then sent to the admins.
![Create Ticket Page](/assets/createTicket.png)


##Liscence

This project is owned by our supervisor Robin Dawes, as well as the Queen's U
Chemistry department.
