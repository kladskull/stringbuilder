# stringbuilder
String Builder Class for PHP - Why you shouldn't even bother.

This class demonstrates that a StringBuilder in PHP doesn't make sense. The 
reason being is that variables in PHP are modifiable (mutable) meaning we can 
modify the string where it sits in memory.

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
$xlen = 0; (the real length of our string - it starts at 0 of course)
```

If we call the String Builders append method with the text 'x1234' it will 
'insert' (not 'copy and append') the string value at position '0', add the 
length of the string to a variable so we know how large our string is:

```php
$x = 'x1234...............';
$xlen = $xlen + strlen('x1234'); (the current length of our string is now 5)
```

If we called the appender again with '5678' it would insert the value at 
position $xlen (which is 5). 

```php
$x = 'x12345678...........'; (periods used for visibility)
$xlen = $xlen + strlen('5678'); (the current length of our string is now 9)
```

When we want the value of the string, a method like .toString() or .str() 
can be called that would basically return the substring of the string buffer. In
our example, it would do something like this: 

$x = 'x12345678...........'; (periods used for visibility)
return substr(buffer, 0, $xlen) which of course returns 'x12345678'. 

As you can see, the original string is much larger than 9, but we only return
what we inserted.

Although a string builder can be optimal, it can also be a total bust. There are 
likely more reasons to just use straight concatenation than a String Builder. 
When a string is returned using .toString() or .str() it actually creates a copy
of the string and returns it. String Builders also use a lot more memory than 
immutable string manipulation would, as it requires (as you can see in our 
example above) that you pre-allocate the space. Doing the preallocation saves
time by not having to call malloc/realloc every append.

mana have to search for enough space in memory 
large enough for the original string as well as what needs to be concatenated 
finally copying the two strings to the new location (it happens very quickly of 
course).

reallocate memory and copy
strings around to simulate this, and of course are immutable. 

However, after messing around trying to squeeze more performance out the 
StringBuilder class I found a great `alternative` StringBuilder that is slightly
quicker than PHP's internal concatenation . 
