# 1dv610 assignment 3

You can find all the documentation on the [wiki-page](https://github.com/Sebastianilsson/1dv610-l3/wiki) or by the links below

The automated test and previously created test cases are fulfilled to 96%. The only test case that is not fulfilled is 4.10 (No feedback: “Registered new user.” or username in the username field). Since I’m using a free version of “Heroku” to host my application and the server “goes to sleep” if the application isn’t used in a while. Therefore you sometimes need to run the automated tests two times directly after each other, otherwise you get a “timed out” on some tests.
The new test cases are fulfilled to 100%. You’ll find the links to the use cases and the test cases below.
Unfortunately I didn’t have all the time I wished I had and therefore the code is not as good as it could be.

- I have a few classes that has grown a bit big (a bit over 200 lines) and have to many private fields. If I had more time, I would refactor the code and divided those classes into two.
- I have left a few “magic numbers” which isn’t preferable.
- I have classes with similar responsibility and content (User, LoginUser and RegisterUser) which violates DRY. If I had more time, I would have created a abstract class that those could have inherit from. (or try something like [this](https://stackoverflow.com/questions/1699796/best-way-to-do-multiple-constructors-in-php) ) The same goes for the class Post.
- I also set messages to the view from the controllers in some cases. This could maybe be moved in the view instead.
- There are for sure much much more but this is what I come up with on the top of my mind

## Instructions on how to run the application locally

Read [this](https://github.com/Sebastianilsson/1dv610-l3/wiki/Instructions-on-how-to-run-the-application-locally) document.

## Test the application online

You find the application [here](https://l3-1dv610.herokuapp.com)

You can login using the username: "test" and password: "testtest" or you can create your own user.

## New use cases for the assignment

Read [this](https://github.com/Sebastianilsson/1dv610-l3/wiki/New-use-cases-for-the-assignment) document.
[Already existing Use Cases](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/UseCases.md). (Not written by me)

## New test cases for the assignment

Read [this](https://github.com/Sebastianilsson/1dv610-l3/wiki/New-test-cases-for-the-assignment) document.
[Already existing Test Cases](https://github.com/dntoll/1dv610/blob/master/assignments/A2_resources/TestCases.md). (Not written by me)
