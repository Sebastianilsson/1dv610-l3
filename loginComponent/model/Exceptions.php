<?php

class MissingUsernameException extends Exception {}
class MissingPasswordException extends Exception {}
class InvalidCharactersInUsername extends Exception {}
class UsernameOrPasswordIsInvalid extends Exception {}
class TamperedCookie extends Exception {}