
# Gmail Api Sender

this software allows you to send emails to list of recipients using your own gmail inbox 

## the setup  
- cd to the software folder and run composer install
- Create an app in google cloud :
- https://console.cloud.google.com/projectcreate
- activate gmail api : 
- https://console.cloud.google.com/marketplace/product/google/gmail.googleapis.com
- add redirection and callback in the app  settings in google cloud
- add scoops (aka permissions) your app needs to send on behalf of the gmail inbox connected
- copy app credential and add it to the software .env file

# the how 
- connect to the gmail inbox by clicking on the "connect" button
- if you do all the above right google will ask you to give permissions to the app you just created .
- allow it
- its will redirect you the software and access token will be generated 
### checking the access token 
- the access token should be visible "almost" in the table after you click  "token list" button 
### adding recipients 
- well its not yet implemented I'm working on it hehe - but you can add it manually, by accessing to the database and add insert them
its not that hard 
## start sending emails
- if you click on "send page" button you will find your connected gmail inbox with some setting and data-list to send email list 
- the send page have to modes :
- "test mode " : this only send an email to test inboxes not the data list 
- "drop mode "  : this will send email to all your data list 
- all the other parameters are self explained 


# TODO-LIST
 - []  user should be able to upload data list
 - []  token crud
 - []  drops crud
 - []  stop and resume the drop aka sending process
 - []  implements design patterns and coding best practices