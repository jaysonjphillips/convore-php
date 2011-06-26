#README

Copyright (c) 2011 Jayson J. Phillips, Chronium Labs LLC


##ABOUT CONVORE-PHP
This class is a simple API wrapper to expose Convore (www.convore.com) methods. This class has no external dependencies and is aimed to be a lightweight drop-in for use in any project or frameworks. It is licensed under the MIT License which follows below.

##EXAMPLE

```php
//create
$con = new Convore( $user, $pass );

//get all groups
//returned as a json_decode object
$result = $con->getAllGroups();

//to grab the first group in the result
print $result->groups[0];
```

###MIT LICENSE

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

_The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software._

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.