;;#####################################################################################
;;#####################################################################################
;; Hotstrings
;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;




;;;; Notes on writing hotstrings
;;;;   Common Code Structure Hotstrings
;;;;      The braces need to be enclosed in braces to be literal
;;;;      The escape character is backtick, not backslash
;;;;
;;;;
;;;;  asterix character makes it not require and ending character to trigger replacement
;;;;  ?  symbol is an option that makes it work even inside another word
;;;;
;;;;  Example:
;;;;      :*?: keyThatGetsPressed::symbolToInsertOrNewlineThenFunctionWithReturnAtEnd
;;;;
;;;;
;;;;  Example2 (This is disabled but would allow underscore on minus minus):
;;;;      :*?:--::_


;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;
;; type in key value pairs in php, with quotes
;;
#+!x::
  ;;;; InputBox works like this:
  ;;;;    InputBox, OutputVar [, Title, Prompt, HIDE, Width, Height,
  ;;;;       X, Y, Font, Timeout, Default]
  ;;;;
  global InputKeyVar
  InputKeyVar := 0
  InputBox, InputKeyVar, "Autohotkey Input - Enter Key", "Key"
  global InputValueVar
  InputValueVar := 0
  InputBox, InputValueVar, "Autohotkey Input - Enter Value", "Value"
  Send % "'"
  Send %InputKeyVar%
  Send % "'"
  Send % " => "
  Send % "'"
  Send %InputValueVar%
  Send % "',"

  return


;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;; 
;; type in key value pairs in php, no quotes on second arg
;;
#+!s::
  ;;;; InputBox works like this:
  ;;;;    InputBox, OutputVar [, Title, Prompt, HIDE, Width, Height,
  ;;;;       X, Y, Font, Timeout, Default]
  ;;;;
  global InputKeyVar
  InputKeyVar := 0
  InputBox, InputKeyVar, "Autohotkey Input - Enter Key", "Key"
  global InputValueVar
  InputValueVar := 0
  InputBox, InputValueVar, "Autohotkey Input - Enter Value", "Value"
  Send % "'"
  Send %InputTagVar%
  Send % "',"
  Send % " => "
  Send %InputKeyVar%
  Send % ","

  return
  
  
  
