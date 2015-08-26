###########################
# Coding conventions      #
###########################

Variables are prepended with the following symbols to overcome non transparency of loose types in PHP:

a For array
s For string
c For character
i For integer
d For double
f For float
o For object
m For map / multi dimensional array
d For database object
r For database result
e For erroneous types when a variable can be multiple types
b For boolean types

In OOP methodology

a For Abstract
o For Object
i For Interface

#############################
# Loops and constructs      #
#############################

foreach($aRows as $iRow => $aRow) {

}

for($iCount=0; $iCount < 10; $iCount++) {

}

while($iCount > 0) {

}

if($iCount == 0) {

} else if($iCount > 0) {

} else {

}

############################
# Pre and post conditions  #
############################

There are various modes which your conditions can be in.
FULL_FAILURE (Throws an exception and the user will see this)
LOG_STATE (Default)
OVERRIDE (No failures for any conditions)

$this->precondition("$iCount > 0", $sCustomlogmessage); Custom log messages are optional
$this->postcondition("$iCount > 0", $sCustomlogmessage); Custom log messages are optional
