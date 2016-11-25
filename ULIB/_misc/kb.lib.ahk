
; AutoHotkey Version: 1.x
; Language:       English
; Platform:       Win9x/NT
; Author:         Suntiparp Plienchote <suntiparp.p@msu.ac.th>
;
; Script Function:
;	Marc Help enter subfields

#SingleInstance

; vars
SetKeyDelay, -1


#NoEnv  ; Recommended for performance and compatibility with future AutoHotkey releases.
SendMode Input  ; Recommended for new scripts due to its superior speed and reliability.
SetWorkingDir %A_ScriptDir%  ; Ensures a consistent starting directory.

menu, tray, NoStandard


menu, tray, add, ช่วยเหลือ 
menu, tray, add, ปิดโปรแกรม 

menu, tray, Default, ช่วยเหลือ

	return


^+A::
	{
	Send, {^}a
	return
}
^+b:: 
	{
	Send, {^}b
	return
}
^+c::
	{
	Send, {^}c
	return
}
^+d::
	{
	Send, {^}d
	return
}
^+e::
	{
	Send, {^}e
	return
}
^+f::
	{
	Send, {^}f
	return
}
^+g::
	{
	Send, {^}g
	return
}
^+h::
	{
	Send, {^}h
	return
}
^+i::
	{
	Send, {^}i
	return
}
^+j::
	{
	Send, {^}j
	return
}
^+k::
	{
	Send, {^}k
	return
}
^+l::
	{
	Send, {^}l
	return
}
^+m::
	{
	Send, {^}m
	return
}
^+n::
	{
	Send, {^}n
	return
}
^+o::
	{
	Send, {^}o
	return
}
^+p::
	{
	Send, {^}p
	return
}
^+q::
	{
	Send, {^}q
	return
}
^+r::
	{
	Send, {^}r
	return
}
^+s::
	{
	Send, {^}s
	return
}
^+t::
	{
	Send, {^}t
	return
}
^+u::
	{
	Send, {^}u
	return
}
^+v::
	{
	Send, {^}v
	return
}
^+w::
	{
	Send, {^}w
	return
}
^+x::
	{
	Send, {^}x
	return
}
^+y::
	{
	Send, {^}y
	return
}
^+z::
	{
	Send, {^}z
	return
}
^+1::
	{
	Send, {^}1
	return
}

^+2::
	{
	Send, {^}2
	return
}
^+3::
	{
	Send, {^}3
	return
}
^+4::
	{
	Send, {^}4
	return
}
^+5::
	{
	Send, {^}5
	return
}
^+6::
	{
	Send, {^}6
	return
}
^+7::
	{
	Send, {^}7
	return
}
^+8::
	{
	Send, {^}8
	return
}
^+9::
	{
	Send, {^}9
	return
}
^+0::
	{
	Send, {^}0
	return
}

^f1::
{
	Send, {^}a
	return
}
^f2::
{
	Send, {^}b
	return
}
^f3::
{
	Send, {^}c
	return
}
^f4::
{
	Send, {^}d
	return
}



^f9::
{
	Send, :
	return
}
^f10::
{
	Send, {^}x
	return
}
^f11::
{
	Send, {^}y
	return
}
^f12::
{
	Send, {^}z
	return
}


ช่วยเหลือ:

	Gui, +AlwaysOnTop -Disabled +SysMenu -Owner  ; +Owner avoids a taskbar button.
	Gui, Add, Text,, เมื่อรันโปรแกรมแล้ว จะปรากฏไอคอนที่บริเวณ System tray.
	Gui, Add, Text,, ให้คลิกขวาที่ไอคอนโปรแกรมเมื่อต้องการแสดงเมนู
	Gui, Add, Text,, Shortcut
	Gui, Add, Text,, - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
	Gui, Add, Text,, Control+F1 = ^a    Control+F2 = ^b    Control+F3 = ^c    Control+F4 = ^d    
	Gui, Add, Text,, Control+F9 = :    Control+F10 = ^x    Control+F11 = ^y    Control+F12 = ^z    

	Gui, Show, NoActivate, ช่วยเหลือ  ; NoActivate avoids deactivating the currently active window.

	return

ปิดโปรแกรม:
	mn_ExitAll()
return

mn_ExitAll() {
	ExitApp 
}
