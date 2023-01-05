# chap11exerPHPpart3

This chapter has multiple parts, and several need additional information. Read through these instructions, and read Chapter 11 in the textbook as directed.

You will be taking screenshots of your running projects. Make sure to name them to identify the task being demonstrated, and use sequential numbers for multiple screenshots in the same task. For example, name images with task1-1, task1-2 for 2 images in Task 1, task2-1, task2-2, task2-3 for 3 images in Task 2, and so on.

 

## Task 5: Performing Transactions

Before starting this section in the book, read more about transactions in Ch 5, pp. 236 - 238. 

The script in this section (Ch 11) uses the Banking database. Before you begin, create that database using THIS FILE Download THIS FILE. Note: Do not use the database file in the textbook download -- there are some errors, and you will find it much easier to use the one provided here. Refer to the instructions in Module 3, "Preparing a Database", to refresh your memory about the process of adding a database to your environment.

Work through this section in Ch 11, creating the transfer.php file. Test it for both successful and unsuccessful transfers. You should notice several issues: (1) The message about success or failure is at the top, under the h1 tag, so the form moves down on the page after the first transaction. (2) The money amounts are not well displayed, there are no commas to separate the values. This occurs in the drop-down menus that display all the customer information. (3) The text on the browser page is small, on the left edge of the window. (4) The page is not "sticky" -- the customers chosen before pressing Submit are not the ones displayed after that click. If the transfer was successful, you don't see the changed balances in the customers. If the transfer failed, you don't see any of information for the customers or the amount to determine where the error was.

Make changes to the PHP script to handle issues 1 through 3. Issue 4 will be part of the Ch 11 Pursue assignment.

For issue (1), you need to display the message about success or failure at the bottom of the page, instead of echoing the paragraphs under the h1 tag. Create 2 variables to hold the messages for success or failure, and assign content to the appropriate variable when you know the result. Remove the echo statements that put the messages at the top of the page. After the Submit button in the HTML, display an H3 tag with the message about success or failure. If the variable for success contains the message, add a class of "success" to the paragraph. If the variable for error contains the message, add a class of "error" to the paragraph. Add CSS in the head tag, with a class for "success" that defines text color of green, and a class for "error" that defines text color of red. The paragraph about the results should display below the Submit button, in either green or red. The message should include the amount. For example, if the transfer of $100 was successful, the message should say: "The transfer of $100 was a success!" If the transfer of $250 was in error, the message should say: "Insufficient funds to complete the transfer of $250." See the images below.

For issue (2), add the number_format() function to format the balance amount, as you did in the Ch 1 Pursue assignment. Create a variable for the balance in the While loop that goes through every account in the database. Assign the balance to it, then format it to use 2 decimal places -- this number_format function puts commas in the number. Change the $options variable to use this formatted variable instead of the data for the balance in the array for the database row.

Also format the amount in the messages about success or failure of the transfer.

For issue (3), add rules to the CSS style in the header. For the body, make the font size large, with margin-left of at least 100px to move it from the left edge of the screen. Add a rule for the select tag and input tag to use large font size, so the content in the drop-down boxes and input area are a similar size to the rest of the text.

 

You will need to take 4 screenshots, before and after pictures of a good transaction and before and after pictures of a bad transaction. Here are examples.

In the first image, it shows the chosen "From" and "To" accounts and the transfer amount BEFORE pressing Submit. Take a screenshot.

![ch11-transfer-1.PNG](https://github.com/bell-kevin/chap11exerPHPpart3/blob/main/readMePictures/ch11-transfer-1.PNG)


Press Submit. In the next image, it shows the "From" and "To" fields returned to the default first row in the database. Select the same accounts chosen before pressing Submit, to compare the balances. Take a screenshot. Here is that result:

![ch11-transfer-2.PNG](https://github.com/bell-kevin/chap11exerPHPpart3/blob/main/readMePictures/ch11-transfer-2.PNG)


In the following image, it shows the chosen "From" and "To" accounts and the transfer amount, which is too large, BEFORE pressing Submit. Take a screenshot.

![ch11-transfer-3.PNG](https://github.com/bell-kevin/chap11exerPHPpart3/blob/main/readMePictures/ch11-transfer-3.PNG)


Press Submit. In the next image, it shows the error message for insufficient funds. As above, the From and To fields are the default first row in the database. Select the same accounts that were chosen before pressing submit, to see that the balances have not changed. Take a screenshot.

![ch11-transfer-4.PNG](https://github.com/bell-kevin/chap11exerPHPpart3/blob/main/readMePictures/ch11-transfer-4.PNG)  

 

Submission: Zip all the files required for successful running of the scripts, and include the 4 specified screenshots. Submit the single zip folder.

== We're Using GitHub Under Protest ==

This project is currently hosted on GitHub.  This is not ideal; GitHub is a
proprietary, trade-secret system that is not Free and Open Souce Software
(FOSS).  We are deeply concerned about using a proprietary system like GitHub
to develop our FOSS project. I have a [website](https://bellKevin.me) where the
project contributors are actively discussing how we can move away from GitHub
in the long term.  We urge you to read about the [Give up GitHub](https://GiveUpGitHub.org) campaign 
from [the Software Freedom Conservancy](https://sfconservancy.org) to understand some of the reasons why GitHub is not 
a good place to host FOSS projects.

If you are a contributor who personally has already quit using GitHub, please
email me at **bellKevin@pm.me** for how to send us contributions without
using GitHub directly.

Any use of this project's code by GitHub Copilot, past or present, is done
without our permission.  We do not consent to GitHub's use of this project's
code in Copilot.

![Logo of the GiveUpGitHub campaign](https://sfconservancy.org/img/GiveUpGitHub.png)
