# StringBuilder.php
<h2>StringBuilders, not happening in PHP</h2>

This class demonstrates that a StringBuilder in PHP doesn't make sense. The 
reason being is that variables in PHP are modifiable (mutable) meaning we can 
modify the string where it sits in memory. I used as many speed tricks as I 
could to squeeze as much out of it as possible - if you can see something I 
missed that would give it a boost, let me know.

When concatenating a string in a language such as C/C++ or Java, a new memory 
area has to be found and allocated to fit the original string plus the string 
being added. In C, this is done by the programmer using malloc/remalloc. In 
languages like Java or C++ (using std::string) this is done automatically. You 
can imagine that concatenating a string in a loop it could take a lot longer 
than it should with all of the reallocation of memory and copying of variables.

A String Builder is quite simple, it preallocates a large block of memory so 
that when more data is added, it doesn't have to reallocate memory and copy 
strings around. For explanation purposes, lets say a string builder preallocates 
20 bytes of empty space: (periods are used for string length visibility)

```php
$x = '....................'; 
$xlen = 0; // (the real length of our string - it starts at 0 of course)
```

If we call the String Builders append method with the text 'x1234' it will 
'insert' (not 'copy and append') the string value at position '0', add the 
length of the string to a variable so we know how large our string is:

```php
$x = 'x1234...............';
$xlen = $xlen + strlen('x1234'); // (the current length of our string is now 5)
```

If we called the appender again with '5678' it would insert the value at 
position $xlen (which is 5). 

```php
$x = 'x12345678...........'; // (periods used for visibility)
$xlen = $xlen + strlen('5678'); // (the current length of our string is now 9)
```

When we want the value of the string, a method like .toString() or .str() 
can be called that would basically return the substring of the string buffer. In
our example, it would do something like this: 

```php
$x = 'x12345678...........'; // (periods used for visibility)
return substr(buffer, 0, $xlen); // which of course returns 'x12345678'. 
```

As you can see, the original string is much larger than 9, but we only return
what we inserted.

Although a string builder can be optimal, it can also be a total bust. There are 
likely more reasons to just use straight concatenation than a String Builder. 
When a string is returned using .toString() or .str() it actually creates a copy
of the string before returning it to the caller. String Builders also use a lot 
more memory than immutable string manipulation would, as the clear source of the 
speed comes from preallocating a block of memory rather than allocating exactly
what it needs, and no more. The preallocation saves time by not having to call 
malloc/realloc every append.
