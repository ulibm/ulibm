var day="";
var month="";
var myweekday="";
var year="";
newdate = new Date();
mydate = new Date();
dston =  new Date('April 4, 2001 2:59:59');
dstoff = new Date('october 31, 2010 2:59:59');
var myzone = newdate.getTimezoneOffset();
newtime=newdate.getTime();

var zone = -7;  

if (newdate > dston && newdate < dstoff ) {
zonea = zone - 1 ;
dst = "  Pacific Daylight Savings Time";
}
else {
zonea = zone ; dst = "  Pacific Standard Time";
}
var newzone = (zonea*60*60*1000);
newtimea = newtime+(myzone*60*1000)-newzone;
mydate.setTime(newtimea);
myday = mydate.getDay();
mymonth = mydate.getMonth();
myweekday= mydate.getDate();
myyear= mydate.getYear();
year = myyear;

if (year < 2000)
year = year + 1900;
myhours = mydate.getHours();
if (myhours >= 12) {
myhours = (myhours == 12) ? 12 : myhours - 12; mm = " PM";
}
else {
myhours = (myhours == 0) ? 12 : myhours; mm = " AM";
}
myminutes = mydate.getMinutes();
if (myminutes < 10){
mytime = ":0" + myminutes;
}
else {
mytime = ":" + myminutes;
};
arday = new 
Array("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัสบดี","ศุกร์","เสาร์")
armonth = new Array("มกราคม ","กุมภาพันธ์ ","มีนาคม ","เมษายน ","พฤษภาคม ","มิถุนายน ","กรกฎาคา ","สิงหายน ","กันยายน ", "ตุลาคม ","พฤษจิกายน ","ธันวาคม ")
ardate = new Array("0","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");


var time = ("<font color=#67A5D1><b>"+arday[myday] +", " + ardate[myweekday] + " " +
armonth[mymonth] + (year+543)+"</b></font>");
document.write(time);

