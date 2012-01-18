# BugKick API #

###Ticket Creating###

To create the ticket you need to send a POST HTTP request 
to [BugKick API URL](https://bugkick.com/api "BugKick API URL") 
with the parameter **apiCall** which should contain next fields:

***apiKey*** - the secret API key of your company,

***projecID*** - the id of your project for which you are creating the ticket,

***ticketText*** - the text of the ticket,

***ticketType*** - the type of the ticket.
Currently next three types of ticket are supproted: 
**"Bug"**, **"Feature request"**, **"Suggestion"**.


----------


We have created a simple PHP library for you which you can use in your projects. 
You can download it **[at the GitHub](https://github.com/BugKick/BugKick-API "BugKick API PHP library")**. 
The index.php file here containing a simple example of usage of this library.

At the moment any API call returns a JSON formatted object containing two properties:

***success*** - contains boolean value that represents the result of call. 
It's equal to TRUE if the call was successful, FALSE otherwise.

***error*** - contains the text of error if the API call failed. Otherwise it is equal to NULL.

If property *success* is equal to FALSE, just look into text of the property *error*.
