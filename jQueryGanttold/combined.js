/**
 * @version: 1.0 Alpha-1
 * @author: Coolite Inc. http://www.coolite.com/
 * @date: 2008-05-13
 * @copyright: Copyright (c) 2006-2008, Coolite Inc. (http://www.coolite.com/). All rights reserved.
 * @license: Licensed under The MIT License. See license.txt and http://www.datejs.com/license/.
 * @website: http://www.datejs.com/
 */
Date.CultureInfo={name:"en-US",englishName:"English (United States)",nativeName:"English (United States)",dayNames:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],abbreviatedDayNames:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],shortestDayNames:["Su","Mo","Tu","We","Th","Fr","Sa"],firstLetterDayNames:["S","M","T","W","T","F","S"],monthNames:["January","February","March","April","May","June","July","August","September","October","November","December"],abbreviatedMonthNames:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],amDesignator:"AM",pmDesignator:"PM",firstDayOfWeek:0,twoDigitYearMax:2029,dateElementOrder:"mdy",formatPatterns:{shortDate:"M/d/yyyy",longDate:"dddd, MMMM dd, yyyy",shortTime:"h:mm tt",longTime:"h:mm:ss tt",fullDateTime:"dddd, MMMM dd, yyyy h:mm:ss tt",sortableDateTime:"yyyy-MM-ddTHH:mm:ss",universalSortableDateTime:"yyyy-MM-dd HH:mm:ssZ",rfc1123:"ddd, dd MMM yyyy HH:mm:ss GMT",monthDay:"MMMM dd",yearMonth:"MMMM, yyyy"},regexPatterns:{jan:/^jan(uary)?/i,feb:/^feb(ruary)?/i,mar:/^mar(ch)?/i,apr:/^apr(il)?/i,may:/^may/i,jun:/^jun(e)?/i,jul:/^jul(y)?/i,aug:/^aug(ust)?/i,sep:/^sep(t(ember)?)?/i,oct:/^oct(ober)?/i,nov:/^nov(ember)?/i,dec:/^dec(ember)?/i,sun:/^su(n(day)?)?/i,mon:/^mo(n(day)?)?/i,tue:/^tu(e(s(day)?)?)?/i,wed:/^we(d(nesday)?)?/i,thu:/^th(u(r(s(day)?)?)?)?/i,fri:/^fr(i(day)?)?/i,sat:/^sa(t(urday)?)?/i,future:/^next/i,past:/^last|past|prev(ious)?/i,add:/^(\+|aft(er)?|from|hence)/i,subtract:/^(\-|bef(ore)?|ago)/i,yesterday:/^yes(terday)?/i,today:/^t(od(ay)?)?/i,tomorrow:/^tom(orrow)?/i,now:/^n(ow)?/i,millisecond:/^ms|milli(second)?s?/i,second:/^sec(ond)?s?/i,minute:/^mn|min(ute)?s?/i,hour:/^h(our)?s?/i,week:/^w(eek)?s?/i,month:/^m(onth)?s?/i,day:/^d(ay)?s?/i,year:/^y(ear)?s?/i,shortMeridian:/^(a|p)/i,longMeridian:/^(a\.?m?\.?|p\.?m?\.?)/i,timezone:/^((e(s|d)t|c(s|d)t|m(s|d)t|p(s|d)t)|((gmt)?\s*(\+|\-)\s*\d\d\d\d?)|gmt|utc)/i,ordinalSuffix:/^\s*(st|nd|rd|th)/i,timeContext:/^\s*(\:|a(?!u|p)|p)/i},timezones:[{name:"UTC",offset:"-000"},{name:"GMT",offset:"-000"},{name:"EST",offset:"-0500"},{name:"EDT",offset:"-0400"},{name:"CST",offset:"-0600"},{name:"CDT",offset:"-0500"},{name:"MST",offset:"-0700"},{name:"MDT",offset:"-0600"},{name:"PST",offset:"-0800"},{name:"PDT",offset:"-0700"}]};
(function(){var $D=Date,$P=$D.prototype,$C=$D.CultureInfo,p=function(s,l){if(!l){l=2;}
    return("000"+s).slice(l*-1);};$P.clearTime=function(){this.setHours(0);this.setMinutes(0);this.setSeconds(0);this.setMilliseconds(0);return this;};$P.setTimeToNow=function(){var n=new Date();this.setHours(n.getHours());this.setMinutes(n.getMinutes());this.setSeconds(n.getSeconds());this.setMilliseconds(n.getMilliseconds());return this;};$D.today=function(){return new Date().clearTime();};$D.compare=function(date1,date2){if(isNaN(date1)||isNaN(date2)){throw new Error(date1+" - "+date2);}else if(date1 instanceof Date&&date2 instanceof Date){return(date1<date2)?-1:(date1>date2)?1:0;}else{throw new TypeError(date1+" - "+date2);}};$D.equals=function(date1,date2){return(date1.compareTo(date2)===0);};$D.getDayNumberFromName=function(name){var n=$C.dayNames,m=$C.abbreviatedDayNames,o=$C.shortestDayNames,s=name.toLowerCase();for(var i=0;i<n.length;i++){if(n[i].toLowerCase()==s||m[i].toLowerCase()==s||o[i].toLowerCase()==s){return i;}}
    return-1;};$D.getMonthNumberFromName=function(name){var n=$C.monthNames,m=$C.abbreviatedMonthNames,s=name.toLowerCase();for(var i=0;i<n.length;i++){if(n[i].toLowerCase()==s||m[i].toLowerCase()==s){return i;}}
    return-1;};$D.isLeapYear=function(year){return((year%4===0&&year%100!==0)||year%400===0);};$D.getDaysInMonth=function(year,month){return[31,($D.isLeapYear(year)?29:28),31,30,31,30,31,31,30,31,30,31][month];};$D.getTimezoneAbbreviation=function(offset){var z=$C.timezones,p;for(var i=0;i<z.length;i++){if(z[i].offset===offset){return z[i].name;}}
    return null;};$D.getTimezoneOffset=function(name){var z=$C.timezones,p;for(var i=0;i<z.length;i++){if(z[i].name===name.toUpperCase()){return z[i].offset;}}
    return null;};$P.clone=function(){return new Date(this.getTime());};$P.compareTo=function(date){return Date.compare(this,date);};$P.equals=function(date){return Date.equals(this,date||new Date());};$P.between=function(start,end){return this.getTime()>=start.getTime()&&this.getTime()<=end.getTime();};$P.isAfter=function(date){return this.compareTo(date||new Date())===1;};$P.isBefore=function(date){return(this.compareTo(date||new Date())===-1);};$P.isToday=function(){return this.isSameDay(new Date());};$P.isSameDay=function(date){return this.clone().clearTime().equals(date.clone().clearTime());};$P.addMilliseconds=function(value){this.setMilliseconds(this.getMilliseconds()+value);return this;};$P.addSeconds=function(value){return this.addMilliseconds(value*1000);};$P.addMinutes=function(value){return this.addMilliseconds(value*60000);};$P.addHours=function(value){return this.addMilliseconds(value*3600000);};$P.addDays=function(value){this.setDate(this.getDate()+value);return this;};$P.addWeeks=function(value){return this.addDays(value*7);};$P.addMonths=function(value){var n=this.getDate();this.setDate(1);this.setMonth(this.getMonth()+value);this.setDate(Math.min(n,$D.getDaysInMonth(this.getFullYear(),this.getMonth())));return this;};$P.addYears=function(value){return this.addMonths(value*12);};$P.add=function(config){if(typeof config=="number"){this._orient=config;return this;}
    var x=config;if(x.milliseconds){this.addMilliseconds(x.milliseconds);}
    if(x.seconds){this.addSeconds(x.seconds);}
    if(x.minutes){this.addMinutes(x.minutes);}
    if(x.hours){this.addHours(x.hours);}
    if(x.weeks){this.addWeeks(x.weeks);}
    if(x.months){this.addMonths(x.months);}
    if(x.years){this.addYears(x.years);}
    if(x.days){this.addDays(x.days);}
    return this;};var $y,$m,$d;$P.getWeek=function(){var a,b,c,d,e,f,g,n,s,w;$y=(!$y)?this.getFullYear():$y;$m=(!$m)?this.getMonth()+1:$m;$d=(!$d)?this.getDate():$d;if($m<=2){a=$y-1;b=(a/4|0)-(a/100|0)+(a/400|0);c=((a-1)/4|0)-((a-1)/100|0)+((a-1)/400|0);s=b-c;e=0;f=$d-1+(31*($m-1));}else{a=$y;b=(a/4|0)-(a/100|0)+(a/400|0);c=((a-1)/4|0)-((a-1)/100|0)+((a-1)/400|0);s=b-c;e=s+1;f=$d+((153*($m-3)+2)/5)+58+s;}
    g=(a+b)%7;d=(f+g-e)%7;n=(f+3-d)|0;if(n<0){w=53-((g-s)/5|0);}else if(n>364+s){w=1;}else{w=(n/7|0)+1;}
    $y=$m=$d=null;return w;};$P.getISOWeek=function(){$y=this.getUTCFullYear();$m=this.getUTCMonth()+1;$d=this.getUTCDate();return p(this.getWeek());};$P.setWeek=function(n){return this.moveToDayOfWeek(1).addWeeks(n-this.getWeek());};$D._validate=function(n,min,max,name){if(typeof n=="undefined"){return false;}else if(typeof n!="number"){throw new TypeError(n+" is not a Number.");}else if(n<min||n>max){throw new RangeError(n+" is not a valid value for "+name+".");}
    return true;};$D.validateMillisecond=function(value){return $D._validate(value,0,999,"millisecond");};$D.validateSecond=function(value){return $D._validate(value,0,59,"second");};$D.validateMinute=function(value){return $D._validate(value,0,59,"minute");};$D.validateHour=function(value){return $D._validate(value,0,23,"hour");};$D.validateDay=function(value,year,month){return $D._validate(value,1,$D.getDaysInMonth(year,month),"day");};$D.validateMonth=function(value){return $D._validate(value,0,11,"month");};$D.validateYear=function(value){return $D._validate(value,0,9999,"year");};$P.set=function(config){if($D.validateMillisecond(config.millisecond)){this.addMilliseconds(config.millisecond-this.getMilliseconds());}
    if($D.validateSecond(config.second)){this.addSeconds(config.second-this.getSeconds());}
    if($D.validateMinute(config.minute)){this.addMinutes(config.minute-this.getMinutes());}
    if($D.validateHour(config.hour)){this.addHours(config.hour-this.getHours());}
    if($D.validateMonth(config.month)){this.addMonths(config.month-this.getMonth());}
    if($D.validateYear(config.year)){this.addYears(config.year-this.getFullYear());}
    if($D.validateDay(config.day,this.getFullYear(),this.getMonth())){this.addDays(config.day-this.getDate());}
    if(config.timezone){this.setTimezone(config.timezone);}
    if(config.timezoneOffset){this.setTimezoneOffset(config.timezoneOffset);}
    if(config.week&&$D._validate(config.week,0,53,"week")){this.setWeek(config.week);}
    return this;};$P.moveToFirstDayOfMonth=function(){return this.set({day:1});};$P.moveToLastDayOfMonth=function(){return this.set({day:$D.getDaysInMonth(this.getFullYear(),this.getMonth())});};$P.moveToNthOccurrence=function(dayOfWeek,occurrence){var shift=0;if(occurrence>0){shift=occurrence-1;}
else if(occurrence===-1){this.moveToLastDayOfMonth();if(this.getDay()!==dayOfWeek){this.moveToDayOfWeek(dayOfWeek,-1);}
    return this;}
    return this.moveToFirstDayOfMonth().addDays(-1).moveToDayOfWeek(dayOfWeek,+1).addWeeks(shift);};$P.moveToDayOfWeek=function(dayOfWeek,orient){var diff=(dayOfWeek-this.getDay()+7*(orient||+1))%7;return this.addDays((diff===0)?diff+=7*(orient||+1):diff);};$P.moveToMonth=function(month,orient){var diff=(month-this.getMonth()+12*(orient||+1))%12;return this.addMonths((diff===0)?diff+=12*(orient||+1):diff);};$P.getOrdinalNumber=function(){return Math.ceil((this.clone().clearTime()-new Date(this.getFullYear(),0,1))/86400000)+1;};$P.getTimezone=function(){return $D.getTimezoneAbbreviation(this.getUTCOffset());};$P.setTimezoneOffset=function(offset){var here=this.getTimezoneOffset(),there=Number(offset)*-6/10;return this.addMinutes(there-here);};$P.setTimezone=function(offset){return this.setTimezoneOffset($D.getTimezoneOffset(offset));};$P.hasDaylightSavingTime=function(){return(Date.today().set({month:0,day:1}).getTimezoneOffset()!==Date.today().set({month:6,day:1}).getTimezoneOffset());};$P.isDaylightSavingTime=function(){return(this.hasDaylightSavingTime()&&new Date().getTimezoneOffset()===Date.today().set({month:6,day:1}).getTimezoneOffset());};$P.getUTCOffset=function(){var n=this.getTimezoneOffset()*-10/6,r;if(n<0){r=(n-10000).toString();return r.charAt(0)+r.substr(2);}else{r=(n+10000).toString();return"+"+r.substr(1);}};$P.getElapsed=function(date){return(date||new Date())-this;};if(!$P.toISOString){$P.toISOString=function(){function f(n){return n<10?'0'+n:n;}
    return'"'+this.getUTCFullYear()+'-'+
        f(this.getUTCMonth()+1)+'-'+
        f(this.getUTCDate())+'T'+
        f(this.getUTCHours())+':'+
        f(this.getUTCMinutes())+':'+
        f(this.getUTCSeconds())+'Z"';};}
    $P._toString=$P.toString;$P.toString=function(format){var x=this;if(format&&format.length==1){var c=$C.formatPatterns;x.t=x.toString;switch(format){case"d":return x.t(c.shortDate);case"D":return x.t(c.longDate);case"F":return x.t(c.fullDateTime);case"m":return x.t(c.monthDay);case"r":return x.t(c.rfc1123);case"s":return x.t(c.sortableDateTime);case"t":return x.t(c.shortTime);case"T":return x.t(c.longTime);case"u":return x.t(c.universalSortableDateTime);case"y":return x.t(c.yearMonth);}}
        var ord=function(n){switch(n*1){case 1:case 21:case 31:return"st";case 2:case 22:return"nd";case 3:case 23:return"rd";default:return"th";}};return format?format.replace(/(\\)?(dd?d?d?|MM?M?M?|yy?y?y?|hh?|HH?|mm?|ss?|tt?|S)/g,function(m){if(m.charAt(0)==="\\"){return m.replace("\\","");}
            x.h=x.getHours;switch(m){case"hh":return p(x.h()<13?(x.h()===0?12:x.h()):(x.h()-12));case"h":return x.h()<13?(x.h()===0?12:x.h()):(x.h()-12);case"HH":return p(x.h());case"H":return x.h();case"mm":return p(x.getMinutes());case"m":return x.getMinutes();case"ss":return p(x.getSeconds());case"s":return x.getSeconds();case"yyyy":return p(x.getFullYear(),4);case"yy":return p(x.getFullYear());case"dddd":return $C.dayNames[x.getDay()];case"ddd":return $C.abbreviatedDayNames[x.getDay()];case"dd":return p(x.getDate());case"d":return x.getDate();case"MMMM":return $C.monthNames[x.getMonth()];case"MMM":return $C.abbreviatedMonthNames[x.getMonth()];case"MM":return p((x.getMonth()+1));case"M":return x.getMonth()+1;case"t":return x.h()<12?$C.amDesignator.substring(0,1):$C.pmDesignator.substring(0,1);case"tt":return x.h()<12?$C.amDesignator:$C.pmDesignator;case"S":return ord(x.getDate());default:return m;}}):this._toString();};}());
(function(){var $D=Date,$P=$D.prototype,$C=$D.CultureInfo,$N=Number.prototype;$P._orient=+1;$P._nth=null;$P._is=false;$P._same=false;$P._isSecond=false;$N._dateElement="day";$P.next=function(){this._orient=+1;return this;};$D.next=function(){return $D.today().next();};$P.last=$P.prev=$P.previous=function(){this._orient=-1;return this;};$D.last=$D.prev=$D.previous=function(){return $D.today().last();};$P.is=function(){this._is=true;return this;};$P.same=function(){this._same=true;this._isSecond=false;return this;};$P.today=function(){return this.same().day();};$P.weekday=function(){if(this._is){this._is=false;return(!this.is().sat()&&!this.is().sun());}
    return false;};$P.at=function(time){return(typeof time==="string")?$D.parse(this.toString("d")+" "+time):this.set(time);};$N.fromNow=$N.after=function(date){var c={};c[this._dateElement]=this;return((!date)?new Date():date.clone()).add(c);};$N.ago=$N.before=function(date){var c={};c[this._dateElement]=this*-1;return((!date)?new Date():date.clone()).add(c);};var dx=("sunday monday tuesday wednesday thursday friday saturday").split(/\s/),mx=("january february march april may june july august september october november december").split(/\s/),px=("Millisecond Second Minute Hour Day Week Month Year").split(/\s/),pxf=("Milliseconds Seconds Minutes Hours Date Week Month FullYear").split(/\s/),nth=("final first second third fourth fifth").split(/\s/),de;$P.toObject=function(){var o={};for(var i=0;i<px.length;i++){o[px[i].toLowerCase()]=this["get"+pxf[i]]();}
    return o;};$D.fromObject=function(config){config.week=null;return Date.today().set(config);};var df=function(n){return function(){if(this._is){this._is=false;return this.getDay()==n;}
    if(this._nth!==null){if(this._isSecond){this.addSeconds(this._orient*-1);}
        this._isSecond=false;var ntemp=this._nth;this._nth=null;var temp=this.clone().moveToLastDayOfMonth();this.moveToNthOccurrence(n,ntemp);if(this>temp){throw new RangeError($D.getDayName(n)+" does not occur "+ntemp+" times in the month of "+$D.getMonthName(temp.getMonth())+" "+temp.getFullYear()+".");}
        return this;}
    return this.moveToDayOfWeek(n,this._orient);};};var sdf=function(n){return function(){var t=$D.today(),shift=n-t.getDay();if(n===0&&$C.firstDayOfWeek===1&&t.getDay()!==0){shift=shift+7;}
    return t.addDays(shift);};};for(var i=0;i<dx.length;i++){$D[dx[i].toUpperCase()]=$D[dx[i].toUpperCase().substring(0,3)]=i;$D[dx[i]]=$D[dx[i].substring(0,3)]=sdf(i);$P[dx[i]]=$P[dx[i].substring(0,3)]=df(i);}
    var mf=function(n){return function(){if(this._is){this._is=false;return this.getMonth()===n;}
        return this.moveToMonth(n,this._orient);};};var smf=function(n){return function(){return $D.today().set({month:n,day:1});};};for(var j=0;j<mx.length;j++){$D[mx[j].toUpperCase()]=$D[mx[j].toUpperCase().substring(0,3)]=j;$D[mx[j]]=$D[mx[j].substring(0,3)]=smf(j);$P[mx[j]]=$P[mx[j].substring(0,3)]=mf(j);}
    var ef=function(j){return function(){if(this._isSecond){this._isSecond=false;return this;}
        if(this._same){this._same=this._is=false;var o1=this.toObject(),o2=(arguments[0]||new Date()).toObject(),v="",k=j.toLowerCase();for(var m=(px.length-1);m>-1;m--){v=px[m].toLowerCase();if(o1[v]!=o2[v]){return false;}
            if(k==v){break;}}
            return true;}
        if(j.substring(j.length-1)!="s"){j+="s";}
        return this["add"+j](this._orient);};};var nf=function(n){return function(){this._dateElement=n;return this;};};for(var k=0;k<px.length;k++){de=px[k].toLowerCase();$P[de]=$P[de+"s"]=ef(px[k]);$N[de]=$N[de+"s"]=nf(de);}
    $P._ss=ef("Second");var nthfn=function(n){return function(dayOfWeek){if(this._same){return this._ss(arguments[0]);}
        if(dayOfWeek||dayOfWeek===0){return this.moveToNthOccurrence(dayOfWeek,n);}
        this._nth=n;if(n===2&&(dayOfWeek===undefined||dayOfWeek===null)){this._isSecond=true;return this.addSeconds(this._orient);}
        return this;};};for(var l=0;l<nth.length;l++){$P[nth[l]]=(l===0)?nthfn(-1):nthfn(l);}}());
(function(){Date.Parsing={Exception:function(s){this.message="Parse error at '"+s.substring(0,10)+" ...'";}};var $P=Date.Parsing;var _=$P.Operators={rtoken:function(r){return function(s){var mx=s.match(r);if(mx){return([mx[0],s.substring(mx[0].length)]);}else{throw new $P.Exception(s);}};},token:function(s){return function(s){return _.rtoken(new RegExp("^\s*"+s+"\s*"))(s);};},stoken:function(s){return _.rtoken(new RegExp("^"+s));},until:function(p){return function(s){var qx=[],rx=null;while(s.length){try{rx=p.call(this,s);}catch(e){qx.push(rx[0]);s=rx[1];continue;}
    break;}
    return[qx,s];};},many:function(p){return function(s){var rx=[],r=null;while(s.length){try{r=p.call(this,s);}catch(e){return[rx,s];}
    rx.push(r[0]);s=r[1];}
    return[rx,s];};},optional:function(p){return function(s){var r=null;try{r=p.call(this,s);}catch(e){return[null,s];}
    return[r[0],r[1]];};},not:function(p){return function(s){try{p.call(this,s);}catch(e){return[null,s];}
    throw new $P.Exception(s);};},ignore:function(p){return p?function(s){var r=null;r=p.call(this,s);return[null,r[1]];}:null;},product:function(){var px=arguments[0],qx=Array.prototype.slice.call(arguments,1),rx=[];for(var i=0;i<px.length;i++){rx.push(_.each(px[i],qx));}
    return rx;},cache:function(rule){var cache={},r=null;return function(s){try{r=cache[s]=(cache[s]||rule.call(this,s));}catch(e){r=cache[s]=e;}
    if(r instanceof $P.Exception){throw r;}else{return r;}};},any:function(){var px=arguments;return function(s){var r=null;for(var i=0;i<px.length;i++){if(px[i]==null){continue;}
    try{r=(px[i].call(this,s));}catch(e){r=null;}
    if(r){return r;}}
    throw new $P.Exception(s);};},each:function(){var px=arguments;return function(s){var rx=[],r=null;for(var i=0;i<px.length;i++){if(px[i]==null){continue;}
    try{r=(px[i].call(this,s));}catch(e){throw new $P.Exception(s);}
    rx.push(r[0]);s=r[1];}
    return[rx,s];};},all:function(){var px=arguments,_=_;return _.each(_.optional(px));},sequence:function(px,d,c){d=d||_.rtoken(/^\s*/);c=c||null;if(px.length==1){return px[0];}
    return function(s){var r=null,q=null;var rx=[];for(var i=0;i<px.length;i++){try{r=px[i].call(this,s);}catch(e){break;}
        rx.push(r[0]);try{q=d.call(this,r[1]);}catch(ex){q=null;break;}
        s=q[1];}
        if(!r){throw new $P.Exception(s);}
        if(q){throw new $P.Exception(q[1]);}
        if(c){try{r=c.call(this,r[1]);}catch(ey){throw new $P.Exception(r[1]);}}
        return[rx,(r?r[1]:s)];};},between:function(d1,p,d2){d2=d2||d1;var _fn=_.each(_.ignore(d1),p,_.ignore(d2));return function(s){var rx=_fn.call(this,s);return[[rx[0][0],r[0][2]],rx[1]];};},list:function(p,d,c){d=d||_.rtoken(/^\s*/);c=c||null;return(p instanceof Array?_.each(_.product(p.slice(0,-1),_.ignore(d)),p.slice(-1),_.ignore(c)):_.each(_.many(_.each(p,_.ignore(d))),px,_.ignore(c)));},set:function(px,d,c){d=d||_.rtoken(/^\s*/);c=c||null;return function(s){var r=null,p=null,q=null,rx=null,best=[[],s],last=false;for(var i=0;i<px.length;i++){q=null;p=null;r=null;last=(px.length==1);try{r=px[i].call(this,s);}catch(e){continue;}
    rx=[[r[0]],r[1]];if(r[1].length>0&&!last){try{q=d.call(this,r[1]);}catch(ex){last=true;}}else{last=true;}
    if(!last&&q[1].length===0){last=true;}
    if(!last){var qx=[];for(var j=0;j<px.length;j++){if(i!=j){qx.push(px[j]);}}
        p=_.set(qx,d).call(this,q[1]);if(p[0].length>0){rx[0]=rx[0].concat(p[0]);rx[1]=p[1];}}
    if(rx[1].length<best[1].length){best=rx;}
    if(best[1].length===0){break;}}
    if(best[0].length===0){return best;}
    if(c){try{q=c.call(this,best[1]);}catch(ey){throw new $P.Exception(best[1]);}
        best[1]=q[1];}
    return best;};},forward:function(gr,fname){return function(s){return gr[fname].call(this,s);};},replace:function(rule,repl){return function(s){var r=rule.call(this,s);return[repl,r[1]];};},process:function(rule,fn){return function(s){var r=rule.call(this,s);return[fn.call(this,r[0]),r[1]];};},min:function(min,rule){return function(s){var rx=rule.call(this,s);if(rx[0].length<min){throw new $P.Exception(s);}
    return rx;};}};var _generator=function(op){return function(){var args=null,rx=[];if(arguments.length>1){args=Array.prototype.slice.call(arguments);}else if(arguments[0]instanceof Array){args=arguments[0];}
    if(args){for(var i=0,px=args.shift();i<px.length;i++){args.unshift(px[i]);rx.push(op.apply(null,args));args.shift();return rx;}}else{return op.apply(null,arguments);}};};var gx="optional not ignore cache".split(/\s/);for(var i=0;i<gx.length;i++){_[gx[i]]=_generator(_[gx[i]]);}
    var _vector=function(op){return function(){if(arguments[0]instanceof Array){return op.apply(null,arguments[0]);}else{return op.apply(null,arguments);}};};var vx="each any all".split(/\s/);for(var j=0;j<vx.length;j++){_[vx[j]]=_vector(_[vx[j]]);}}());(function(){var $D=Date,$P=$D.prototype,$C=$D.CultureInfo;var flattenAndCompact=function(ax){var rx=[];for(var i=0;i<ax.length;i++){if(ax[i]instanceof Array){rx=rx.concat(flattenAndCompact(ax[i]));}else{if(ax[i]){rx.push(ax[i]);}}}
    return rx;};$D.Grammar={};$D.Translator={hour:function(s){return function(){this.hour=Number(s);};},minute:function(s){return function(){this.minute=Number(s);};},second:function(s){return function(){this.second=Number(s);};},meridian:function(s){return function(){this.meridian=s.slice(0,1).toLowerCase();};},timezone:function(s){return function(){var n=s.replace(/[^\d\+\-]/g,"");if(n.length){this.timezoneOffset=Number(n);}else{this.timezone=s.toLowerCase();}};},day:function(x){var s=x[0];return function(){this.day=Number(s.match(/\d+/)[0]);};},month:function(s){return function(){this.month=(s.length==3)?"jan feb mar apr may jun jul aug sep oct nov dec".indexOf(s)/4:Number(s)-1;};},year:function(s){return function(){var n=Number(s);this.year=((s.length>2)?n:(n+(((n+2000)<$C.twoDigitYearMax)?2000:1900)));};},rday:function(s){return function(){switch(s){case"yesterday":this.days=-1;break;case"tomorrow":this.days=1;break;case"today":this.days=0;break;case"now":this.days=0;this.now=true;break;}};},finishExact:function(x){x=(x instanceof Array)?x:[x];for(var i=0;i<x.length;i++){if(x[i]){x[i].call(this);}}
    var now=new Date();if((this.hour||this.minute)&&(!this.month&&!this.year&&!this.day)){this.day=now.getDate();}
    if(!this.year){this.year=now.getFullYear();}
    if(!this.month&&this.month!==0){this.month=now.getMonth();}
    if(!this.day){this.day=1;}
    if(!this.hour){this.hour=0;}
    if(!this.minute){this.minute=0;}
    if(!this.second){this.second=0;}
    if(this.meridian&&this.hour){if(this.meridian=="p"&&this.hour<12){this.hour=this.hour+12;}else if(this.meridian=="a"&&this.hour==12){this.hour=0;}}
    if(this.day>$D.getDaysInMonth(this.year,this.month)){throw new RangeError(this.day+" is not a valid value for days.");}
    var r=new Date(this.year,this.month,this.day,this.hour,this.minute,this.second);if(this.timezone){r.set({timezone:this.timezone});}else if(this.timezoneOffset){r.set({timezoneOffset:this.timezoneOffset});}
    return r;},finish:function(x){x=(x instanceof Array)?flattenAndCompact(x):[x];if(x.length===0){return null;}
    for(var i=0;i<x.length;i++){if(typeof x[i]=="function"){x[i].call(this);}}
    var today=$D.today();if(this.now&&!this.unit&&!this.operator){return new Date();}else if(this.now){today=new Date();}
    var expression=!!(this.days&&this.days!==null||this.orient||this.operator);var gap,mod,orient;orient=((this.orient=="past"||this.operator=="subtract")?-1:1);if(!this.now&&"hour minute second".indexOf(this.unit)!=-1){today.setTimeToNow();}
    if(this.month||this.month===0){if("year day hour minute second".indexOf(this.unit)!=-1){this.value=this.month+1;this.month=null;expression=true;}}
    if(!expression&&this.weekday&&!this.day&&!this.days){var temp=Date[this.weekday]();this.day=temp.getDate();if(!this.month){this.month=temp.getMonth();}
        this.year=temp.getFullYear();}
    if(expression&&this.weekday&&this.unit!="month"){this.unit="day";gap=($D.getDayNumberFromName(this.weekday)-today.getDay());mod=7;this.days=gap?((gap+(orient*mod))%mod):(orient*mod);}
    if(this.month&&this.unit=="day"&&this.operator){this.value=(this.month+1);this.month=null;}
    if(this.value!=null&&this.month!=null&&this.year!=null){this.day=this.value*1;}
    if(this.month&&!this.day&&this.value){today.set({day:this.value*1});if(!expression){this.day=this.value*1;}}
    if(!this.month&&this.value&&this.unit=="month"&&!this.now){this.month=this.value;expression=true;}
    if(expression&&(this.month||this.month===0)&&this.unit!="year"){this.unit="month";gap=(this.month-today.getMonth());mod=12;this.months=gap?((gap+(orient*mod))%mod):(orient*mod);this.month=null;}
    if(!this.unit){this.unit="day";}
    if(!this.value&&this.operator&&this.operator!==null&&this[this.unit+"s"]&&this[this.unit+"s"]!==null){this[this.unit+"s"]=this[this.unit+"s"]+((this.operator=="add")?1:-1)+(this.value||0)*orient;}else if(this[this.unit+"s"]==null||this.operator!=null){if(!this.value){this.value=1;}
        this[this.unit+"s"]=this.value*orient;}
    if(this.meridian&&this.hour){if(this.meridian=="p"&&this.hour<12){this.hour=this.hour+12;}else if(this.meridian=="a"&&this.hour==12){this.hour=0;}}
    if(this.weekday&&!this.day&&!this.days){var temp=Date[this.weekday]();this.day=temp.getDate();if(temp.getMonth()!==today.getMonth()){this.month=temp.getMonth();}}
    if((this.month||this.month===0)&&!this.day){this.day=1;}
    if(!this.orient&&!this.operator&&this.unit=="week"&&this.value&&!this.day&&!this.month){return Date.today().setWeek(this.value);}
    if(expression&&this.timezone&&this.day&&this.days){this.day=this.days;}
    return(expression)?today.add(this):today.set(this);}};var _=$D.Parsing.Operators,g=$D.Grammar,t=$D.Translator,_fn;g.datePartDelimiter=_.rtoken(/^([\s\-\.\,\/\x27]+)/);g.timePartDelimiter=_.stoken(":");g.whiteSpace=_.rtoken(/^\s*/);g.generalDelimiter=_.rtoken(/^(([\s\,]|at|@|on)+)/);var _C={};g.ctoken=function(keys){var fn=_C[keys];if(!fn){var c=$C.regexPatterns;var kx=keys.split(/\s+/),px=[];for(var i=0;i<kx.length;i++){px.push(_.replace(_.rtoken(c[kx[i]]),kx[i]));}
    fn=_C[keys]=_.any.apply(null,px);}
    return fn;};g.ctoken2=function(key){return _.rtoken($C.regexPatterns[key]);};g.h=_.cache(_.process(_.rtoken(/^(0[0-9]|1[0-2]|[1-9])/),t.hour));g.hh=_.cache(_.process(_.rtoken(/^(0[0-9]|1[0-2])/),t.hour));g.H=_.cache(_.process(_.rtoken(/^([0-1][0-9]|2[0-3]|[0-9])/),t.hour));g.HH=_.cache(_.process(_.rtoken(/^([0-1][0-9]|2[0-3])/),t.hour));g.m=_.cache(_.process(_.rtoken(/^([0-5][0-9]|[0-9])/),t.minute));g.mm=_.cache(_.process(_.rtoken(/^[0-5][0-9]/),t.minute));g.s=_.cache(_.process(_.rtoken(/^([0-5][0-9]|[0-9])/),t.second));g.ss=_.cache(_.process(_.rtoken(/^[0-5][0-9]/),t.second));g.hms=_.cache(_.sequence([g.H,g.m,g.s],g.timePartDelimiter));g.t=_.cache(_.process(g.ctoken2("shortMeridian"),t.meridian));g.tt=_.cache(_.process(g.ctoken2("longMeridian"),t.meridian));g.z=_.cache(_.process(_.rtoken(/^((\+|\-)\s*\d\d\d\d)|((\+|\-)\d\d\:?\d\d)/),t.timezone));g.zz=_.cache(_.process(_.rtoken(/^((\+|\-)\s*\d\d\d\d)|((\+|\-)\d\d\:?\d\d)/),t.timezone));g.zzz=_.cache(_.process(g.ctoken2("timezone"),t.timezone));g.timeSuffix=_.each(_.ignore(g.whiteSpace),_.set([g.tt,g.zzz]));g.time=_.each(_.optional(_.ignore(_.stoken("T"))),g.hms,g.timeSuffix);g.d=_.cache(_.process(_.each(_.rtoken(/^([0-2]\d|3[0-1]|\d)/),_.optional(g.ctoken2("ordinalSuffix"))),t.day));g.dd=_.cache(_.process(_.each(_.rtoken(/^([0-2]\d|3[0-1])/),_.optional(g.ctoken2("ordinalSuffix"))),t.day));g.ddd=g.dddd=_.cache(_.process(g.ctoken("sun mon tue wed thu fri sat"),function(s){return function(){this.weekday=s;};}));g.M=_.cache(_.process(_.rtoken(/^(1[0-2]|0\d|\d)/),t.month));g.MM=_.cache(_.process(_.rtoken(/^(1[0-2]|0\d)/),t.month));g.MMM=g.MMMM=_.cache(_.process(g.ctoken("jan feb mar apr may jun jul aug sep oct nov dec"),t.month));g.y=_.cache(_.process(_.rtoken(/^(\d\d?)/),t.year));g.yy=_.cache(_.process(_.rtoken(/^(\d\d)/),t.year));g.yyy=_.cache(_.process(_.rtoken(/^(\d\d?\d?\d?)/),t.year));g.yyyy=_.cache(_.process(_.rtoken(/^(\d\d\d\d)/),t.year));_fn=function(){return _.each(_.any.apply(null,arguments),_.not(g.ctoken2("timeContext")));};g.day=_fn(g.d,g.dd);g.month=_fn(g.M,g.MMM);g.year=_fn(g.yyyy,g.yy);g.orientation=_.process(g.ctoken("past future"),function(s){return function(){this.orient=s;};});g.operator=_.process(g.ctoken("add subtract"),function(s){return function(){this.operator=s;};});g.rday=_.process(g.ctoken("yesterday tomorrow today now"),t.rday);g.unit=_.process(g.ctoken("second minute hour day week month year"),function(s){return function(){this.unit=s;};});g.value=_.process(_.rtoken(/^\d\d?(st|nd|rd|th)?/),function(s){return function(){this.value=s.replace(/\D/g,"");};});g.expression=_.set([g.rday,g.operator,g.value,g.unit,g.orientation,g.ddd,g.MMM]);_fn=function(){return _.set(arguments,g.datePartDelimiter);};g.mdy=_fn(g.ddd,g.month,g.day,g.year);g.ymd=_fn(g.ddd,g.year,g.month,g.day);g.dmy=_fn(g.ddd,g.day,g.month,g.year);g.date=function(s){return((g[$C.dateElementOrder]||g.mdy).call(this,s));};g.format=_.process(_.many(_.any(_.process(_.rtoken(/^(dd?d?d?|MM?M?M?|yy?y?y?|hh?|HH?|mm?|ss?|tt?|zz?z?)/),function(fmt){if(g[fmt]){return g[fmt];}else{throw $D.Parsing.Exception(fmt);}}),_.process(_.rtoken(/^[^dMyhHmstz]+/),function(s){return _.ignore(_.stoken(s));}))),function(rules){return _.process(_.each.apply(null,rules),t.finishExact);});var _F={};var _get=function(f){return _F[f]=(_F[f]||g.format(f)[0]);};g.formats=function(fx){if(fx instanceof Array){var rx=[];for(var i=0;i<fx.length;i++){rx.push(_get(fx[i]));}
    return _.any.apply(null,rx);}else{return _get(fx);}};g._formats=g.formats(["\"yyyy-MM-ddTHH:mm:ssZ\"","yyyy-MM-ddTHH:mm:ssZ","yyyy-MM-ddTHH:mm:ssz","yyyy-MM-ddTHH:mm:ss","yyyy-MM-ddTHH:mmZ","yyyy-MM-ddTHH:mmz","yyyy-MM-ddTHH:mm","ddd, MMM dd, yyyy H:mm:ss tt","ddd MMM d yyyy HH:mm:ss zzz","MMddyyyy","ddMMyyyy","Mddyyyy","ddMyyyy","Mdyyyy","dMyyyy","yyyy","Mdyy","dMyy","d"]);g._start=_.process(_.set([g.date,g.time,g.expression],g.generalDelimiter,g.whiteSpace),t.finish);g.start=function(s){try{var r=g._formats.call({},s);if(r[1].length===0){return r;}}catch(e){}
    return g._start.call({},s);};$D._parse=$D.parse;$D.parse=function(s){var r=null;if(!s){return null;}
    if(s instanceof Date){return s;}
    try{r=$D.Grammar.start.call({},s.replace(/^\s*(\S*(\s+\S+)*)\s*$/,"$1"));}catch(e){return null;}
    return((r[1].length===0)?r[0]:null);};$D.getParseFunction=function(fx){var fn=$D.Grammar.formats(fx);return function(s){var r=null;try{r=fn.call({},s);}catch(e){return null;}
    return((r[1].length===0)?r[0]:null);};};$D.parseExact=function(s,fx){return $D.getParseFunction(fx)(s);};}());



(function($){$.extend($.fn,{livequery:function(type,fn,fn2){var self=this,q;if($.isFunction(type))fn2=fn,fn=type,type=undefined;$.each($.livequery.queries,function(i,query){if(self.selector==query.selector&&self.context==query.context&&type==query.type&&(!fn||fn.$lqguid==query.fn.$lqguid)&&(!fn2||fn2.$lqguid==query.fn2.$lqguid))return(q=query)&&false});q=q||new $.livequery(this.selector,this.context,type,fn,fn2);q.stopped=false;q.run();return this},expire:function(type,fn,fn2){var self=this;if($.isFunction(type))fn2=
    fn,fn=type,type=undefined;$.each($.livequery.queries,function(i,query){if(self.selector==query.selector&&self.context==query.context&&(!type||type==query.type)&&(!fn||fn.$lqguid==query.fn.$lqguid)&&(!fn2||fn2.$lqguid==query.fn2.$lqguid)&&!this.stopped)$.livequery.stop(query.id)});return this}});$.livequery=function(selector,context,type,fn,fn2){this.selector=selector;this.context=context;this.type=type;this.fn=fn;this.fn2=fn2;this.elements=[];this.stopped=false;this.id=$.livequery.queries.push(this)-
    1;fn.$lqguid=fn.$lqguid||$.livequery.guid++;if(fn2)fn2.$lqguid=fn2.$lqguid||$.livequery.guid++;return this};$.livequery.prototype={stop:function(){var query=this;if(this.type)this.elements.unbind(this.type,this.fn);else if(this.fn2)this.elements.each(function(i,el){query.fn2.apply(el)});this.elements=[];this.stopped=true},run:function(){if(this.stopped)return;var query=this;var oEls=this.elements,els=$(this.selector,this.context),nEls=els.not(oEls);this.elements=els;if(this.type){nEls.bind(this.type,
    this.fn);if(oEls.length>0)$.each(oEls,function(i,el){if($.inArray(el,els)<0)$.event.remove(el,query.type,query.fn)})}else{nEls.each(function(){query.fn.apply(this)});if(this.fn2&&oEls.length>0)$.each(oEls,function(i,el){if($.inArray(el,els)<0)query.fn2.apply(el)})}}};$.extend($.livequery,{guid:0,queries:[],queue:[],running:false,timeout:null,checkQueue:function(){if($.livequery.running&&$.livequery.queue.length){var length=$.livequery.queue.length;while(length--)$.livequery.queries[$.livequery.queue.shift()].run()}},
    pause:function(){$.livequery.running=false},play:function(){$.livequery.running=true;$.livequery.run()},registerPlugin:function(){$.each(arguments,function(i,n){if(!$.fn[n])return;var old=$.fn[n];$.fn[n]=function(){var r=old.apply(this,arguments);$.livequery.run();return r}})},run:function(id){if(id!=undefined){if($.inArray(id,$.livequery.queue)<0)$.livequery.queue.push(id)}else $.each($.livequery.queries,function(id){if($.inArray(id,$.livequery.queue)<0)$.livequery.queue.push(id)});if($.livequery.timeout)clearTimeout($.livequery.timeout);
        $.livequery.timeout=setTimeout($.livequery.checkQueue,20)},stop:function(id){if(id!=undefined)$.livequery.queries[id].stop();else $.each($.livequery.queries,function(id){$.livequery.queries[id].stop()})}});$.livequery.registerPlugin("append","prepend","after","before","wrap","attr","removeAttr","addClass","removeClass","toggleClass","empty","remove","html");$(function(){$.livequery.play()})})(jQuery);


jQuery.fn.extend({
    everyTime: function(interval, label, fn, times, belay) {
        return this.each(function() {
            jQuery.timer.add(this, interval, label, fn, times, belay);
        });
    },
    oneTime: function(interval, label, fn) {
        return this.each(function() {
            jQuery.timer.add(this, interval, label, fn, 1);
        });
    },
    stopTime: function(label, fn) {
        return this.each(function() {
            jQuery.timer.remove(this, label, fn);
        });
    }
});

jQuery.extend({
    timer: {
        guid: 1,
        global: {},
        regex: /^([0-9]+)\s*(.*s)?$/,
        powers: {
            // Yeah this is major overkill...
            'ms': 1,
            'cs': 10,
            'ds': 100,
            's': 1000,
            'das': 10000,
            'hs': 100000,
            'ks': 1000000
        },
        timeParse: function(value) {
            if (value == undefined || value == null)
                return null;
            var result = this.regex.exec(jQuery.trim(value.toString()));
            if (result[2]) {
                var num = parseInt(result[1], 10);
                var mult = this.powers[result[2]] || 1;
                return num * mult;
            } else {
                return value;
            }
        },
        add: function(element, interval, label, fn, times, belay) {
            var counter = 0;

            if (jQuery.isFunction(label)) {
                if (!times)
                    times = fn;
                fn = label;
                label = interval;
            }

            interval = jQuery.timer.timeParse(interval);

            if (typeof interval != 'number' || isNaN(interval) || interval <= 0)
                return;

            if (times && times.constructor != Number) {
                belay = !!times;
                times = 0;
            }

            times = times || 0;
            belay = belay || false;

            if (!element.$timers)
                element.$timers = {};

            if (!element.$timers[label])
                element.$timers[label] = {};

            fn.$timerID = fn.$timerID || this.guid++;

            var handler = function() {
                if (belay && this.inProgress)
                    return;
                this.inProgress = true;
                if ((++counter > times && times !== 0) || fn.call(element, counter) === false)
                    jQuery.timer.remove(element, label, fn);
                this.inProgress = false;
            };

            handler.$timerID = fn.$timerID;

            if (!element.$timers[label][fn.$timerID])
                element.$timers[label][fn.$timerID] = window.setInterval(handler,interval);

            if ( !this.global[label] )
                this.global[label] = [];
            this.global[label].push( element );

        },
        remove: function(element, label, fn) {
            var timers = element.$timers, ret;

            if ( timers ) {

                if (!label) {
                    for ( label in timers )
                        this.remove(element, label, fn);
                } else if ( timers[label] ) {
                    if ( fn ) {
                        if ( fn.$timerID ) {
                            window.clearInterval(timers[label][fn.$timerID]);
                            delete timers[label][fn.$timerID];
                        }
                    } else {
                        for ( var fn in timers[label] ) {
                            window.clearInterval(timers[label][fn]);
                            delete timers[label][fn];
                        }
                    }

                    for ( ret in timers[label] ) break;
                    if ( !ret ) {
                        ret = null;
                        delete timers[label];
                    }
                }

                for ( ret in timers ) break;
                if ( !ret )
                    element.$timers = null;
            }
        }
    }
});

jQuery(window).one("unload", function() {
    var global = jQuery.timer.global;
    for ( var label in global ) {
        var els = global[label], i = els.length;
        while ( --i )
            jQuery.timer.remove(els[i], label);
    }
});




/*
 Copyright (c) 2012-2017 Open Lab
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */



// works also for IE8 beta
var isExplorer = navigator.userAgent.toUpperCase().indexOf("MSIE") >= 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./);
var isMozilla = navigator.userAgent.toUpperCase().indexOf("FIREFOX") >= 0;
var isSafari = navigator.userAgent.toLowerCase().indexOf("safari") != -1 && navigator.userAgent.toLowerCase().indexOf('chrome') < 0;

//Version detection
var version = navigator.appVersion.substring(0, 1);
var inProduction = false;
if (inProduction) {
    window.console = undefined;
}

// deprecated use $("#domid")...
function obj(element) {
    if (arguments.length > 1) {
        alert("invalid use of obj with multiple params:" + element)
    }
    var el = document.getElementById(element);
    if (!el)
        console.error("element not found: " + element);
    return el;
}

if (!window.console) {
    window.console = new function () {
        this.log = function (str) {/*alert(str)*/};
        this.debug = function (str) {/*alert(str)*/};
        this.error = function (str) {/*alert(str)*/};
    };
}
if (!window.console.debug || !window.console.error || !window.console.log) {
    window.console = new function () {
        this.log = function (str) {/*alert(str)*/};
        this.debug = function (str) {/*alert(str)*/};
        this.error = function (str) {/*alert(str)*/};
    };
}



String.prototype.trim = function () {
    return this.replace(/^\s*(\S*(\s+\S+)*)\s*$/, "$1");
};

String.prototype.startsWith = function (t, i) {
    if (!i) {
        return (t == this.substring(0, t.length));
    } else {
        return (t.toLowerCase() == this.substring(0, t.length).toLowerCase());
    }
};

String.prototype.endsWith = function (t, i) {
    if (!i) {
        return (t == this.substring(this.length - t.length));
    } else {
        return (t.toLowerCase() == this.substring(this.length - t.length).toLowerCase());
    }
};

// leaves only char from A to Z, numbers, _ -> valid ID
String.prototype.asId = function () {
    return this.replace(/[^a-zA-Z0-9_]+/g, '');
};

String.prototype.replaceAll = function (from, to) {
    return this.replace(new RegExp(RegExp.quote(from), 'g'), to);
};


if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (searchElement, fromIndex) {
        if (this == null) {
            throw new TypeError();
        }
        var t = Object(this);
        var len = t.length >>> 0;
        if (len === 0) {
            return -1;
        }
        var n = 0;
        if (arguments.length > 0) {
            n = Number(arguments[1]);
            if (n != n) { // shortcut for verifying if it's NaN
                n = 0;
            } else if (n != 0 && n != Infinity && n != -Infinity) {
                n = (n > 0 || -1) * Math.floor(Math.abs(n));
            }
        }
        if (n >= len) {
            return -1;
        }
        var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);
        for (; k < len; k++) {
            if (k in t && t[k] === searchElement) {
                return k;
            }
        }
        return -1;
    };
}


Object.size = function (obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};


// transform string values to printable: \n in <br>
function transformToPrintable(data) {
    for (var prop in data) {
        var value = data[prop];
        if (typeof(value) == "string")
            data[prop] = (value + "").replace(/\n/g, "<br>");
    }
    return data;
}


RegExp.quote = function (str) {
    return str.replace(/([.?*+^$[\]\\(){}-])/g, "\\$1");
};


/* Object Functions */

function stopBubble(e) {
    e.stopPropagation();
    e.preventDefault();
    return false;
}


// ------ ------- -------- wraps http://www.mysite.com/.......   with <a href="...">
jQuery.fn.activateLinks = function (showImages) {
    var httpRE = /(['"]\s*)?(http[s]?:[\d]*\/\/[^"<>\s]*)/g;
    var wwwRE = /(['"/]\s*)?(www\.[^"<>\s]+)/g;
    var imgRE = /(['"]\s*)?(http[s]?:[\d]*\/\/[^"<>\s]*\.(?:gif|jpg|png|jpeg|bmp))/g;


    this.each(function () {
        var el = $(this);
        var html = el.html();

        if (showImages) {
            // workaround for negative look ahead
            html = html.replace(imgRE, function ($0, $1) {
                return $1 ? $0 : "<div class='imgWrap'  onclick=\"window.open('" + $0 + "','_blank');event.stopPropagation();\"><img src='" + $0 + "' title='" + $0 + "'></div>";
            });
        }

        html = html.replace(httpRE, function ($0, $1) {
            return $1 ? $0 : "<a href='#' onclick=\"window.open('" + $0 + "','_blank');event.stopPropagation();\">" + $0 + "</a>";
        });

        html = html.replace(wwwRE, function ($0, $1) {
            return $1 ? $0 : "<a href='#' onclick=\"window.open('http://" + $0 + "','_blank');event.stopPropagation();\">" + $0 + "</a>";
        });

        el.empty().append(html);

        if (showImages) {
            //inject expand capability on images
            el.find("div.imgWrap").each(function () {
                var imageDiv = $(this);


                imageDiv.click(function (e) {
                    if (e.ctrlKey || e.metaKey) {
                        window.open(imageDiv.find("img").prop("src"), "_blank");
                    } else {
                        var imageClone = imageDiv.find("img").clone();
                        imageClone.mouseout(function () {
                            $(this).remove();
                        });
                        imageClone.addClass("imageClone").css({"position":"absolute", "display":"none", "top":imageDiv.position().top, "left":imageDiv.position().left, "z-index":1000000});
                        imageDiv.after(imageClone);
                        imageClone.fadeIn();
                    }
                });
            });
        }

    });
    return this;
};

jQuery.fn.emoticonize = function () {
    function convert(text) {
        var faccRE = /(:\))|(:-\))|(:-])|(:-\()|(:\()|(:-\/)|(:-\\)|(:-\|)|(;-\))|(:-D)|(:-P)|(:-p)|(:-0)|(:-o)|(:-O)|(:'-\()|(\(@\))/g;
        return text.replace(faccRE, function (str) {
            var ret = {":)":"smile",
                ":-)":"smile",
                ":-]":"polite_smile",
                ":-(":"frown",
                ":(":"frown",
                ":-/":"skepticism",
                ":-\\":"skepticism",
                ":-|":"sarcasm",
                ";-)":"wink",
                ":-D":"grin",
                ":-P":"tongue",
                ":-p":"tongue",
                ":-o":"surprise",
                ":-O":"surprise",
                ":-0":"surprise",
                ":'-(":"tear",
                "(@)":"angry"}[str];
            if (ret) {
                ret = "<img src='" + contextPath + "/img/smiley/" + ret + ".png' align='absmiddle'>";
                return ret;
            } else
                return str;
        });
    }

    function addBold(text) {
        var returnedValue;
        var faccRE = /\*\*[^*]*\*\*/ig;
        return text.replace(faccRE, function (str) {
            var temp = str.substr(2);
            var temp2 = temp.substr(0, temp.length - 2);
            return "<b>" + temp2 + "</b>";
        });
    }

    this.each(function () {
        var el = $(this);
        var html = convert(el.html());
        html = addBold(html);
        el.html(html);
    });
    return this;
};


$.fn.unselectable = function () {
    this.each(function () {
        $(this).addClass("unselectable").attr("unselectable", "on");
    });
    return $(this);
};

$.fn.clearUnselectable = function () {
    this.each(function () {
        $(this).removeClass("unselectable").removeAttr("unselectable");
    });
    return $(this);
};

// ---------------------------------- initialize management
var __initedComponents = new Object();

function initialize(url, type, ndo) {
    //console.debug("initialize before: " + url);
    var normUrl = url.asId();
    var deferred = $.Deferred();

    if (!__initedComponents[normUrl]) {
        __initedComponents[normUrl] = deferred;

        if ("CSS" == (type + "").toUpperCase()) {
            var link = $("<link rel='stylesheet' type='text/css'>").prop("href", url);
            $("head").append(link);
            deferred.resolve();

        } else if ("SCRIPT" == (type + "").toUpperCase()) {
            $.ajax({type: "GET",
                url:        url + "?" + buildNumber,
                dataType:   "script",
                cache:      true,
                success:    function () {
                    //console.debug("initialize loaded:" + url);
                    deferred.resolve()
                },
                error:      function () {
                    //console.debug("initialize failed:" + url);
                    deferred.reject();
                }
            });


        } else {
            //console.debug(url+" as DOM");
            //var text = getContent(url);
            url = url + (url.indexOf("?") > -1 ? "&" : "?") + buildNumber;
            var text = $.ajax({
                type:     "GET",
                url:      url,
                dataType: "html",
                cache:    true,
                success:  function (text) {
                    //console.debug("initialize loaded:" + url);
                    ndo = ndo || $("body");
                    ndo.append(text);
                    deferred.resolve()
                },
                error:    function () {
                    //console.debug("initialize failed:" + url);
                    deferred.reject();
                }
            });
        }
    }

    return __initedComponents[normUrl].promise();
}


/**
 *  callback receive event, data
 *  data.response  contiene la response json arrivata dal controller
 *  E.G.:
 *     $("body").trigger("worklogEvent",[{type:"delete",response:response}])
 *
 *     in caso di delete di solito c'è il response.deletedId
 */
function registerEvent(eventName,callback) {
    $("body").off(eventName).on(eventName, callback);
}


function openPersistentFile(file) {
    //console.debug("openPersistentFile",file);
    var t=window.self;
    try{
        if(window.top != window.self)
            t=window.top;
    } catch(e) {}

    if (file.mime.indexOf("image") >= 0) {
        var img = $("<img>").prop("src", file.url).css({position: "absolute", top: "-10000px", left: "-10000px"}).one("load", function () {
            //console.debug("image loaded");
            var img = $(this);
            var w = img.width();
            var h = img.height();
            //console.debug("image loaded",w,h);
            var f=w/h;
            var ww = $(t).width()*.8;
            var wh = $(t).height()*.8;
            if (w>ww){
                w=ww;
                h=w/f;
            }
            if (h>wh){
                h=wh;
                w=h*f;
            }

            var hasTop=false;
            img.width(w).height(h).css({position: "static", top: 0, left: 0});

            t.createModalPopup(w+100,h+100).append(img);
        });
        t.$("body").append(img);
    } else if (file.mime.indexOf("pdf") >= 0) {
        t.openBlackPopup(file.url, $(t).width()*.8, $(t).height()*.8);
    } else {
        window.open(file.url + "&TREATASATTACH=yes");
    }
}


function wrappedEvaluer(toEval){
    eval(toEval);
}

function evalInContext(stringToEval,context){
    wrappedEvaluer.apply(context,[stringToEval]);
}


Storage.prototype.setObject = function(key, value) {
    this.setItem(key, JSON.stringify(value));
};

Storage.prototype.getObject = function(key) {
    return this.getItem(key) && JSON.parse(this.getItem(key));
};

function objectSize(size) {
    var divisor = 1;
    var unit = "bytes";
    if (size >= 1024 * 1024) {
        divisor = 1024 * 1024;
        unit = "MB";
    } else if (size >= 1024) {
        divisor = 1024;
        unit = "KB";
    }
    if (divisor == 1)
        return size + " " + unit;

    return (size / divisor).toFixed(2) + ' ' + unit;
}


function htmlEncode(value){
    //create a in-memory div, set it's inner text(which jQuery automatically encodes)
    //then grab the encoded contents back out.  The div never exists on the page.
    return $('<div/>').text(value).html();
}

function htmlLinearize(value, length){
    value = value.replace(/(\r\n|\n|\r)/gm,"").replace(/<br>/g, " - ");
    value = value.replace(/-  -/g, "-");

    var ret = $('<div/>').text(value).text();

    if(length){
        var ellips = ret.length > length ? "..." : "";
        ret = ret.substring(0,length) + ellips;
    }

    return ret;
}

function htmlDecode(value){
    return $('<div/>').html(value).text();
}



function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

function eraseCookie(name) {
    createCookie(name,"",-1);
}



function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

$.fn.isEmptyElement = function( ){
    return !$.trim($(this).html())
};

//workaround for jquery 3.x
if (typeof ($.fn.size)!="funcion")
    $.fn.size=function(){return this.length};



/*
 Copyright (c) 2012-2017 Open Lab
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

var muteAlertOnChange = false;


// isRequired ----------------------------------------------------------------------------

//return true if every mandatory field is filled and highlight empty ones
jQuery.fn.isFullfilled = function () {
    var canSubmit = true;
    var firstErrorElement = "";

    this.each(function () {
        var theElement = $(this);
        theElement.removeClass("formElementsError");
        //if (theElement.val().trim().length == 0 || theElement.attr("invalid") == "true") {  //robicch 13/2/15
        if (theElement.is("[required]") && theElement.val().trim().length == 0 || theElement.attr("invalid") == "true") {
            if (theElement.attr("type") == "hidden") {
                theElement = theElement.prevAll("#" + theElement.prop("id") + "_txt:first");
            } else if (theElement.is("[withTinyMCE]")){
                if (tinymce.activeEditor.getContent()=="")
                    theElement=$("#"+theElement.attr("name")+"_tbl");
                else
                    return true;// in order to continue the loop
            }
            theElement.addClass("formElementsError");
            canSubmit = false;

            if (firstErrorElement == "")
                firstErrorElement = theElement;
        }
    });

    if (!canSubmit) {
        // get the tabdiv
        var theTabDiv = firstErrorElement.closest(".tabBox");
        if (theTabDiv.length > 0)
            clickTab(theTabDiv.attr("tabId"));

        // highlight element
        firstErrorElement.effect("highlight", { color:"red" }, 1500);
    }
    return canSubmit;

};

function canSubmitForm(formOrId) {
    //console.debug("canSubmitForm",formOrId);
    if (typeof formOrId != "object")
        formOrId=$("#" + formOrId);
    return formOrId.find(":input[required],:input[invalid=true]").isFullfilled();
}

function showSavingMessage() {
    $("#savingMessage:hidden").fadeIn();
    $("body").addClass("waiting");
    $(window).resize();
}
function hideSavingMessage() {
    $("#savingMessage:visible").fadeOut();
    $("body").removeClass("waiting");
    $(window).resize();
}



/* Types Function */

function isValidURL(url) {
    var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/;
    return RegExp.test(url);
}

function isValidEmail(email) {
    //var RegExp = /^((([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+(\.([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+)*)@((((([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.))*([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.)[\w]{2,4}|(((([0-9]){1,3}\.){3}([0-9]){1,3}))|(\[((([0-9]){1,3}\.){3}([0-9]){1,3})\])))$/;
    var RegExp = /^.+@\S+\.\S+$/;
    return RegExp.test(email);
}

function isValidInteger(n) {
    reg = new RegExp("^[-+]{0,1}[0-9]*$");
    return reg.test(n) || isNumericExpression(n);
}

function isValidDouble(n) {
    var sep = Number.decimalSeparator;
    reg = new RegExp("^[-+]{0,1}[0-9]*[" + sep + "]{0,1}[0-9]*$");
    return reg.test(n) || isNumericExpression(n);
}

function isValidTime(n) {
    return !isNaN(millisFromHourMinute(n));
}

function isValidDurationDays(n) {
    return !isNaN(daysFromString(n));
}

function isValidDurationMillis(n) {
    return !isNaN(millisFromString(n));
}

function isNumericExpression(expr) {
    try {
        var a = eval(expr);
        return typeof(a) == 'number';
    } catch (t) {
        return false;
    }

}

function getNumericExpression(expr) {
    var ret;
    try {
        var a = eval(expr);
        if (typeof(a) == 'number')
            ret = a;
    } catch (t) {
    }
    return ret;

}

/*
 supports almost all Java currency format e.g.: ###,##0.00EUR   €#,###.00  #,###.00€  -$#,###.00  $-#,###.00
 */
function isValidCurrency(numStr) {
    //first try to convert format in a regex
    var regex = "";
    var format = Number.currencyFormat + "";

    var minusFound = false;
    var numFound = false;
    var currencyString = "";
    var numberRegex = "[0-9\\" + Number.groupingSeparator + "]+[\\" + Number.decimalSeparator + "]?[0-9]*";

    for (var i = 0; i < format.length; i++) {
        var ch = format.charAt(i);

        if (ch == "." || ch == "," || ch == "0") {
            //skip it
            if (currencyString != "") {
                regex = regex + "(?:" + RegExp.quote(currencyString) + ")?";
                currencyString = "";
            }

        } else if (ch == "#") {
            if (currencyString != "") {
                regex = regex + "(?:" + RegExp.quote(currencyString) + ")?";
                currencyString = "";
            }

            if (!numFound) {
                numFound = true;
                regex = regex + numberRegex;
            }

        } else if (ch == "-") {
            if (currencyString != "") {
                regex = regex + "(?:" + RegExp.quote(currencyString) + ")?";
                currencyString = "";
            }
            if (!minusFound) {
                minusFound = true;
                regex = regex + "[-]?";
            }

        } else {
            currencyString = currencyString + ch;
        }
    }
    if (!minusFound)
        regex = "[-]?" + regex;

    if (currencyString != "")
        regex = regex + "(?:" + RegExp.quote(currencyString) + ")?";

    regex = "^" + regex + "$";

    var rg = new RegExp(regex);
    return rg.test(numStr) || isNumericExpression(numStr);
}

function getCurrencyValue(numStr) {
    if (!isValidCurrency(numStr))
        return NaN;

    var ripul = numStr.replaceAll(Number.groupingSeparator, "").replaceAll(Number.decimalSeparator, ".");
    return getNumericExpression(ripul) || parseFloat(ripul.replace(/[^-0123456789.]/, ""));
}


function formatCurrency(numberString) {
    return formatNumber(numberString, Number.currencyFormat);
}


function formatNumber(numberString, format) {
    if (!format)
        format = "##0.00";

    var dec = Number.decimalSeparator;
    var group = Number.groupingSeparator;
    var neg = Number.minusSign;

    var round = true;

    var validFormat = "0#-,.";

    // strip all the invalid characters at the beginning and the end
    // of the format, and we'll stick them back on at the end
    // make a special case for the negative sign "-" though, so
    // we can have formats like -$23.32
    var prefix = "";
    var negativeInFront = false;
    for (var i = 0; i < format.length; i++) {
        if (validFormat.indexOf(format.charAt(i)) == -1) {
            prefix = prefix + format.charAt(i);
        } else {
            if (i == 0 && format.charAt(i) == '-') {
                negativeInFront = true;
            } else {
                break;
            }
        }
    }
    var suffix = "";
    for (var i = format.length - 1; i >= 0; i--) {
        if (validFormat.indexOf(format.charAt(i)) == -1)
            suffix = format.charAt(i) + suffix;
        else
            break;
    }

    format = format.substring(prefix.length);
    format = format.substring(0, format.length - suffix.length);

    // now we need to convert it into a number
    //while (numberString.indexOf(group) > -1)
    //	numberString = numberString.replace(group, '');
    //var number = new Number(numberString.replace(dec, ".").replace(neg, "-"));
    var number = new Number(numberString);


    var forcedToZero = false;
    if (isNaN(number)) {
        number = 0;
        forcedToZero = true;
    }

    // special case for percentages
    if (suffix == "%")
        number = number * 100;

    var returnString = "";
    if (format.indexOf(".") > -1) {
        var decimalPortion = dec;
        var decimalFormat = format.substring(format.lastIndexOf(".") + 1);

        // round or truncate number as needed
        if (round)
            number = new Number(number.toFixed(decimalFormat.length));
        else {
            var numStr = number.toString();
            numStr = numStr.substring(0, numStr.lastIndexOf('.') + decimalFormat.length + 1);
            number = new Number(numStr);
        }

        var decimalValue = number % 1;
        var decimalString = new String(decimalValue.toFixed(decimalFormat.length));
        decimalString = decimalString.substring(decimalString.lastIndexOf(".") + 1);

        for (var i = 0; i < decimalFormat.length; i++) {
            if (decimalFormat.charAt(i) == '#' && decimalString.charAt(i) != '0') {
                decimalPortion += decimalString.charAt(i);
            } else if (decimalFormat.charAt(i) == '#' && decimalString.charAt(i) == '0') {
                var notParsed = decimalString.substring(i);
                if (notParsed.match('[1-9]')) {
                    decimalPortion += decimalString.charAt(i);
                } else {
                    break;
                }
            } else if (decimalFormat.charAt(i) == "0") {
                decimalPortion += decimalString.charAt(i);
            }
        }
        returnString += decimalPortion;
    } else {
        number = Math.round(number);
    }
    var ones = Math.floor(number);
    if (number < 0)
        ones = Math.ceil(number);

    var onesFormat = "";
    if (format.indexOf(".") == -1)
        onesFormat = format;
    else
        onesFormat = format.substring(0, format.indexOf("."));

    var onePortion = "";
    if (!(ones == 0 && onesFormat.substr(onesFormat.length - 1) == '#') || forcedToZero) {
        // find how many digits are in the group
        var oneText = new String(Math.abs(ones));
        var groupLength = 9999;
        if (onesFormat.lastIndexOf(",") != -1)
            groupLength = onesFormat.length - onesFormat.lastIndexOf(",") - 1;
        var groupCount = 0;
        for (var i = oneText.length - 1; i > -1; i--) {
            onePortion = oneText.charAt(i) + onePortion;
            groupCount++;
            if (groupCount == groupLength && i != 0) {
                onePortion = group + onePortion;
                groupCount = 0;
            }
        }

        // account for any pre-data padding
        if (onesFormat.length > onePortion.length) {
            var padStart = onesFormat.indexOf('0');
            if (padStart != -1) {
                var padLen = onesFormat.length - padStart;

                // pad to left with 0's or group char
                var pos = onesFormat.length - onePortion.length - 1;
                while (onePortion.length < padLen) {
                    var padChar = onesFormat.charAt(pos);
                    // replace with real group char if needed
                    if (padChar == ',')
                        padChar = group;
                    onePortion = padChar + onePortion;
                    pos--;
                }
            }
        }
    }

    if (!onePortion && onesFormat.indexOf('0', onesFormat.length - 1) !== -1)
        onePortion = '0';

    returnString = onePortion + returnString;

    // handle special case where negative is in front of the invalid characters
    if (number < 0 && negativeInFront && prefix.length > 0)
        prefix = neg + prefix;
    else if (number < 0)
        returnString = neg + returnString;

    if (returnString.lastIndexOf(dec) == returnString.length - 1) {
        returnString = returnString.substring(0, returnString.length - 1);
    }
    returnString = prefix + returnString + suffix;
    return returnString;
}


//validation functions - used by textfield and datefield
jQuery.fn.validateField = function () {
    var isValid = true;

    this.each(function () {
        var el = $(this);
        el.clearErrorAlert();

        var value = el.val();
        if (value) {
            var rett = true;
            var type = (el.attr('entryType')+"").toUpperCase();
            var errParam;

            if (type == "INTEGER") {
                rett = isValidInteger(value);
            } else if (type == "DOUBLE") {
                rett = isValidDouble(value);
            } else if (type == "PERCENTILE") {
                rett = isValidDouble(value);
            } else if (type == "URL") {
                rett = isValidURL(value);
            } else if (type == "EMAIL") {
                rett = isValidEmail(value);
            } else if (type == "DURATIONMILLIS") {
                rett = isValidDurationMillis(value);
            } else if (type == "DURATIONDAYS") {
                rett = isValidDurationDays(value);
            } else if (type == "DATE") {
                rett = Date.isValid(value, el.attr("format"), true);
                if (!rett)
                    errParam = el.attr("format");
            } else if (type == "TIME") {
                rett = isValidTime(value);
            } else if (type == "CURRENCY") {
                rett = isValidCurrency(value);
            }

            if (!rett) {
                el.createErrorAlert(i18n.ERROR_ON_FIELD, i18n.INVALID_DATA + (errParam ? " " + errParam : ""));
                isValid=false;
            }


            //check limits  minValue : maxValue
            if (rett && (el.attr("minValue") || el.attr("maxValue"))){
                var val=value;
                var min=el.attr("minValue");
                var max=el.attr("maxValue");
                if (type == "INTEGER") {
                    val=parseInt(value);
                    min=parseInt(min);
                    max=parseInt(max);
                } else if (type == "DOUBLE" || type == "PERCENTILE") {
                    val=parseDouble(value);
                    min=parseDouble(min);
                    max=parseDouble(max);
                } else if (type == "URL") {
                    val=value;
                } else if (type == "EMAIL") {
                    val=value;
                } else if (type == "DURATIONMILLIS") {
                    val=millisFromString(value);
                    min=millisFromString(min);
                    max=millisFromString(max);

                } else if (type == "DURATIONDAYS") {
                    val=daysFromString(value);
                    min=daysFromString(min);
                    max=daysFromString(max);
                } else if (type == "DATE") {
                    val=Date.parseString(value, el.attr("format"),true).getTime();
                    min=Date.parseString(min, el.attr("format"),true).getTime();
                    max=Date.parseString(max, el.attr("format"),true).getTime();
                } else if (type == "TIME") {
                    val = millisFromHourMinute(value);
                    min = millisFromHourMinute(min);
                    max = millisFromHourMinute(max);
                } else if (type == "CURRENCY") {
                    val=getCurrencyValue(value);
                    min=getCurrencyValue(min);
                    max=getCurrencyValue(max);
                }

                if (el.attr("minValue") && val<min){
                    el.createErrorAlert(i18n.ERROR_ON_FIELD, i18n.OUT_OF_BOUDARIES + " ("+el.attr("minValue")+" : "+(el.attr("maxValue")?el.attr("maxValue"):"--")+")");
                    rett=false;
                    isValid=false;

                    $("body").trigger("error");
                }

                if (rett && el.attr("maxValue") && val>max){
                    el.createErrorAlert(i18n.ERROR_ON_FIELD, i18n.OUT_OF_BOUDARIES + " ("+(el.attr("minValue")?el.attr("minValue"):"--")+" : "+el.attr("maxValue")+")");
                    rett=false;
                    isValid=false;
                }

            }

        }

    });

    return isValid;
};

jQuery.fn.clearErrorAlert = function () {
    this.each(function () {
        var el = $(this);
        el.removeAttr("invalid").removeClass("formElementsError");
        $("#" + el.prop("id") + "error").remove();
    });
    return this;
};

jQuery.fn.createErrorAlert = function (errorCode, message) {
    this.each(function () {
        var el = $(this);
        el.attr("invalid", "true").addClass("formElementsError");
        if ($("#" + el.prop("id") + "error").length <= 0) {
            var errMess = (errorCode ? errorCode : "") + ": " + (message ? message : "");
            var err = "<span class='formElementExclamation' id=\"" + el.prop("id") + "error\" error='1'";
            err += " onclick=\"alert($(this).attr('title'))\" border='0' align='absmiddle'>&nbsp;";
            err += "</span>\n";
            err = $(err);
            err.prop("title", errMess);
            el.after(err);
        }
    });
    return this;
};


// button submit support BEGIN ------------------

function saveFormValues(idForm) {
    var formx = obj(idForm);
    formx.setAttribute("savedAction", formx.action);
    formx.setAttribute("savedTarget", formx.target);
    var el = formx.elements;
    for (i = 0; i < el.length; i++) {
        if (el[i].getAttribute("savedValue") != null) {
            el[i].setAttribute("savedValue", el[i].value);
        }
    }
}

function restoreFormValues(idForm) {
    var formx = obj(idForm);
    formx.action = formx.getAttribute("savedAction");
    formx.target = formx.getAttribute("savedTarget");
    var el = formx.elements;
    for (i = 0; i < el.length; i++) {
        if (el[i].getAttribute("savedValue") != null) {
            el[i].value = el[i].getAttribute("savedValue");
        }
    }
}

function changeActionAndSubmit(action,command){
    var f=$("form:first");
    f.prop("action",action);
    f.find("[name=CM]").val(command);
    f.submit();
}



// textarea limit size -------------------------------------------------
function limitSize(ob) {
    if (ob.getAttribute("maxlength")) {
        var ml =parseInt(ob.getAttribute("maxlength"));
        var val = ob.value;//.replace(/\r\n/g,"\n");
        if (val.length > ml) {
            ob.value = val.substr(0, ml);
            $(ob).createErrorAlert("Error",i18n.ERR_FIELD_MAX_SIZE_EXCEEDED);
        } else {
            $(ob).clearErrorAlert();
        }
    }
    return true;
}


// verify before unload BEGIN ----------------------------------------------------------------------------

function alertOnUnload(container) {
    //console.debug("alertOnUnload",container,muteAlertOnChange);
    if (!muteAlertOnChange) {

        //first try to call a function eventually defined on the page
        if (typeof(managePageUnload) == "function")
            managePageUnload();

        container=container||$("body");
        var inps= $("[alertonchange=true]",container).find("[oldValue=1]");
        for (var j = 0; j < inps.length; j++) {
            var anInput = inps.eq(j);
            //console.debug(j,anInput,anInput.isValueChanged())
            var oldValue = anInput.getOldValue() + "";
            if (!('true' == '' + anInput.attr('excludeFromAlert'))) {
                if (anInput.attr("maleficoTiny")) {
                    if (tinymce.EditorManager.get(anInput.prop("id")).isDirty()) {
                        return i18n.FORM_IS_CHANGED + " \"" + anInput.prop("name") + "\"";
                    }

                } else if (anInput.isValueChanged()) {
                    var inputLabel = $("label[for='" + anInput.prop("id") + "']").text(); //use label element
                    inputLabel = inputLabel ? inputLabel : anInput.prop("name");
                    return i18n.FORM_IS_CHANGED + " \"" + inputLabel + "\"";
                }
            }
        }
    }
    return undefined;
}

function canILeave(){
    var ret = window.onbeforeunload();
    if (typeof(ret)!="undefined" && !confirm(ret+"  \n"+i18n.PROCEED))
        return false;
    else
        return true;
}

// ---------------------------------- oldvalues management
// update all values selected
jQuery.fn.updateOldValue = function () {
    this.each(function () {
        var el = $(this);
        var val=(el.is(":checkbox,:radio")?el.prop("checked"):el.val())+"";
        el.data("_oldvalue", val);
    });
    return this;
};

// return true if at least one element has changed
jQuery.fn.isValueChanged = function () {
    var ret = false;
    this.each(function () {
        var el = $(this);
        var val=(el.is(":checkbox,:radio")?el.prop("checked"):el.val())+"";
        if (val != el.data("_oldvalue") + "") {
            //console.debug("io sono diverso "+el.prop("id")+ " :"+el.val()+" != "+el.data("_oldvalue"));
            ret = true;
            return false;
        }
    });
    return ret;
};

jQuery.fn.getOldValue = function () {
    return $(this).data("_oldvalue");
};

jQuery.fn.fillJsonWithInputValues = function (jsonObject) {
    var inputs = this.find(":input");
    $.each(inputs.serializeArray(),function(){
        if (this.name) {
            jsonObject[this.name] = this.value;
        }
    });

    inputs.filter(":checkbox[name]").each(function () {
        var el = $(this);
        jsonObject[el.attr("name")] = el.is(":checked") ? "yes" : "no";

    })

    return this;
};



function enlargeTextArea(immediate) {
    //console.debug("enlargeTextArea",immediate);
    var el = $(this);

    var delay=immediate===true?1:300;
    el.stopTime("taResizeApply");
    el.oneTime(delay,"taResizeApply",function(){

        var miH = el.is("[minHeight]") ? parseInt(el.attr("minHeight")) : 30;
        var maH = el.is("[maxHeight]") ? parseInt(el.attr("maxHeight")) : 400;
        var inc = el.is("[lineHeight]") ? parseInt(el.attr("lineHeight")) : 30;

        //si copiano nel css per sicurezza
        el.css({maxHeight:maH,minHeight:miH});

        var domEl = el.get(0);
        var pad = el.outerHeight()-el.height();
        //devo allargare
        if (domEl.scrollHeight>el.outerHeight() && el.outerHeight()<maH){
            var nh=domEl.scrollHeight-pad + inc;
            nh=nh>maH-pad?maH-pad:nh;
            el.height(nh);
        } else if (el.height()>miH){
            //devo stringere
            el.height(el.height()-inc);

            while(el.outerHeight()-domEl.scrollHeight > 0 && el.height()>miH){
                el.height(el.height()-inc);
            }
            var newH=domEl.scrollHeight-pad +inc;
            //newH=newH<minH?minH:newH;
            el.height(newH);

        }
        el.stopTime("winResize");
    });

}









/**
 * Copyright (c)2005-2009 Matt Kruse (javascripttoolbox.com)
 * Dual licensed under the MIT and GPL licenses.
 * This basically means you can use this code however you want for
 */
/*
 Date functions

 These functions are used to parse, format, and manipulate Date objects.
 See documentation and examples at http://www.JavascriptToolbox.com/lib/date/

 */
Date.$VERSION = 1.02;

// Utility function to append a 0 to single-digit numbers
Date.LZ = function(x) {return(x<0||x>9?"":"0")+x};
// Full month names. Change this for local month names
Date.monthNames = new Array('January','February','March','April','May','June','July','August','September','October','November','December');
// Month abbreviations. Change this for local month names
Date.monthAbbreviations = new Array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
// Full day names. Change this for local month names
Date.dayNames = new Array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
// Day abbreviations. Change this for local month names
Date.dayAbbreviations = new Array('Sun','Mon','Tue','Wed','Thu','Fri','Sat');
// Used for parsing ambiguous dates like 1/2/2000 - default to preferring 'American' format meaning Jan 2.
// Set to false to prefer 'European' format meaning Feb 1
Date.preferAmericanFormat = true;

// Set to 0=SUn for American 1=Mon for european
Date.firstDayOfWeek = 0;

//default
Date.defaultFormat="dd/MM/yyyy";

// If the getFullYear() method is not defined, create it
if (!Date.prototype.getFullYear) {
    Date.prototype.getFullYear = function() { var yy=this.getYear(); return (yy<1900?yy+1900:yy); } ;
}

// Parse a string and convert it to a Date object.
// If no format is passed, try a list of common formats.
// If string cannot be parsed, return null.
// Avoids regular expressions to be more portable.
Date.parseString = function(val, format,lenient) {
    // If no format is specified, try a few common formats
    if (typeof(format)=="undefined" || format==null || format=="") {
        var generalFormats=new Array(Date.defaultFormat,'y-M-d','MMM d, y','MMM d,y','y-MMM-d','d-MMM-y','MMM d','MMM-d','d-MMM');
        var monthFirst=new Array('M/d/y','M-d-y','M.d.y','M/d','M-d');
        var dateFirst =new Array('d/M/y','d-M-y','d.M.y','d/M','d-M');
        var checkList=new Array(generalFormats,Date.preferAmericanFormat?monthFirst:dateFirst,Date.preferAmericanFormat?dateFirst:monthFirst);
        for (var i=0; i<checkList.length; i++) {
            var l=checkList[i];
            for (var j=0; j<l.length; j++) {
                var d=Date.parseString(val,l[j]);
                if (d!=null) {
                    return d;
                }
            }
        }
        return null;
    };

    this.isInteger = function(val) {
        for (var i=0; i < val.length; i++) {
            if ("1234567890".indexOf(val.charAt(i))==-1) {
                return false;
            }
        }
        return true;
    };
    this.getInt = function(str,i,minlength,maxlength) {
        for (var x=maxlength; x>=minlength; x--) {
            var token=str.substring(i,i+x);
            if (token.length < minlength) {
                return null;
            }
            if (this.isInteger(token)) {
                return token;
            }
        }
        return null;
    };




    this.decodeShortcut=function(str){
        str=str?str:""; // just in case
        var dateUpper = str.trim().toUpperCase();
        var ret=new Date();
        ret.clearTime();

        if (["NOW","N"].indexOf(dateUpper)>=0) {
            ret= new Date();

        } else if (["TODAY","T"].indexOf(dateUpper)>=0) {
            //do nothing

        } else if (["YESTERDAY","Y"].indexOf(dateUpper)>=0) {
            ret.setDate(ret.getDate()-1);

        } else if (["TOMORROW","TO"].indexOf(dateUpper)>=0) {
            ret.setDate(ret.getDate()+1);

        } else if (["W", "TW", "WEEK", "THISWEEK", "WEEKSTART", "THISWEEKSTART"].indexOf(dateUpper)>=0) {
            ret.setFirstDayOfThisWeek();

        } else if (["LW", "LASTWEEK", "LASTWEEKSTART"].indexOf(dateUpper)>=0) {
            ret.setFirstDayOfThisWeek();
            ret.setDate(ret.getDate()-7);

        } else if (["NW", "NEXTWEEK", "NEXTWEEKSTART"].indexOf(dateUpper)>=0) {
            ret.setFirstDayOfThisWeek();
            ret.setDate(ret.getDate()+7);

        } else if (["M", "TM", "MONTH", "THISMONTH", "MONTHSTART", "THISMONTHSTART"].indexOf(dateUpper)>=0) {
            ret.setDate(1);

        } else if (["LM", "LASTMONTH", "LASTMONTHSTART"].indexOf(dateUpper)>=0) {
            ret.setDate(1);
            ret.setMonth(ret.getMonth()-1);

        } else if (["NM", "NEXTMONTH", "NEXTMONTHSTART"].indexOf(dateUpper)>=0) {
            ret.setDate(1);
            ret.setMonth(ret.getMonth()+1);

        } else if (["Q", "TQ", "QUARTER", "THISQUARTER", "QUARTERSTART", "THISQUARTERSTART"].indexOf(dateUpper)>=0) {
            ret.setDate(1);
            ret.setMonth(Math.floor((ret.getMonth()) / 3) * 3);

        } else if (["LQ", "LASTQUARTER", "LASTQUARTERSTART"].indexOf(dateUpper)>=0) {
            ret.setDate(1);
            ret.setMonth(Math.floor((ret.getMonth()) / 3) * 3-3);

        } else if (["NQ", "NEXTQUARTER", "NEXTQUARTERSTART"].indexOf(dateUpper)>=0) {
            ret.setDate(1);
            ret.setMonth(Math.floor((ret.getMonth()) / 3) * 3+3);


        } else if (/^-?[0-9]+[DWMY]$/.test(dateUpper)) {
            var lastOne = dateUpper.substr(dateUpper.length - 1);
            var val = parseInt(dateUpper.substr(0, dateUpper.length - 1));
            if (lastOne=="W")
                ret.setDate(ret.getDate()+val*7 );
            else if (lastOne=="M")
                ret.setMonth(ret.getMonth()+val );
            else if (lastOne=="Y")
                ret.setYear(ret.getYear()+val );
        } else {
            ret=undefined;
        }

        return ret;
    };

    var ret=this.decodeShortcut(val);
    if (ret)
        return ret;

    this._getDate = function(val, format) {
        val = val + "";
        format = format + "";
        var i_val = 0;
        var i_format = 0;
        var c = "";
        var token = "";
        var token2 = "";
        var x,y;
        var year = new Date().getFullYear();
        var month = 1;
        var date = 1;
        var hh = 0;
        var mm = 0;
        var ss = 0;
        var ampm = "";
        while (i_format < format.length) {
            // Get next token from format string
            c = format.charAt(i_format);
            token = "";
            while ((format.charAt(i_format) == c) && (i_format < format.length)) {
                token += format.charAt(i_format++);
            }
            // Extract contents of value based on format token
            if (token == "yyyy" || token == "yy" || token == "y") {
                if (token == "yyyy") {
                    x = 4;
                    y = 4;
                }
                if (token == "yy") {
                    x = 2;
                    y = 2;
                }
                if (token == "y") {
                    x = 2;
                    y = 4;
                }
                year = this.getInt(val, i_val, x, y);
                if (year == null) {
                    return null;
                }
                i_val += year.length;
                if (year.length == 2) {
                    if (year > 70) {
                        year = 1900 + (year - 0);
                    }
                    else {
                        year = 2000 + (year - 0);
                    }
                }

                //		} else if (token=="MMM" || token=="NNN"){
            } else if (token == "MMM" || token == "MMMM") {
                month = 0;
                var names = (token == "MMMM" ? (Date.monthNames.concat(Date.monthAbbreviations)) : Date.monthAbbreviations);
                for (var i = 0; i < names.length; i++) {
                    var month_name = names[i];
                    if (val.substring(i_val, i_val + month_name.length).toLowerCase() == month_name.toLowerCase()) {
                        month = (i % 12) + 1;
                        i_val += month_name.length;
                        break;
                    }
                }
                if ((month < 1) || (month > 12)) {
                    return null;
                }
            } else if (token == "E" || token == "EE" || token == "EEE" || token == "EEEE") {
                var names = (token == "EEEE" ? Date.dayNames : Date.dayAbbreviations);
                for (var i = 0; i < names.length; i++) {
                    var day_name = names[i];
                    if (val.substring(i_val, i_val + day_name.length).toLowerCase() == day_name.toLowerCase()) {
                        i_val += day_name.length;
                        break;
                    }
                }
            } else if (token == "MM" || token == "M") {
                month = this.getInt(val, i_val, token.length, 2);
                if (month == null || (month < 1) || (month > 12)) {
                    return null;
                }
                i_val += month.length;
            } else if (token == "dd" || token == "d") {
                date = this.getInt(val, i_val, token.length, 2);
                if (date == null || (date < 1) || (date > 31)) {
                    return null;
                }
                i_val += date.length;
            } else if (token == "hh" || token == "h") {
                hh = this.getInt(val, i_val, token.length, 2);
                if (hh == null || (hh < 1) || (hh > 12)) {
                    return null;
                }
                i_val += hh.length;
            } else if (token == "HH" || token == "H") {
                hh = this.getInt(val, i_val, token.length, 2);
                if (hh == null || (hh < 0) || (hh > 23)) {
                    return null;
                }
                i_val += hh.length;
            } else if (token == "KK" || token == "K") {
                hh = this.getInt(val, i_val, token.length, 2);
                if (hh == null || (hh < 0) || (hh > 11)) {
                    return null;
                }
                i_val += hh.length;
                hh++;
            } else if (token == "kk" || token == "k") {
                hh = this.getInt(val, i_val, token.length, 2);
                if (hh == null || (hh < 1) || (hh > 24)) {
                    return null;
                }
                i_val += hh.length;
                hh--;
            } else if (token == "mm" || token == "m") {
                mm = this.getInt(val, i_val, token.length, 2);
                if (mm == null || (mm < 0) || (mm > 59)) {
                    return null;
                }
                i_val += mm.length;
            } else if (token == "ss" || token == "s") {
                ss = this.getInt(val, i_val, token.length, 2);
                if (ss == null || (ss < 0) || (ss > 59)) {
                    return null;
                }
                i_val += ss.length;
            } else if (token == "a") {
                if (val.substring(i_val, i_val + 2).toLowerCase() == "am") {
                    ampm = "AM";
                } else if (val.substring(i_val, i_val + 2).toLowerCase() == "pm") {
                    ampm = "PM";
                } else {
                    return null;
                }
                i_val += 2;
            } else {
                if (val.substring(i_val, i_val + token.length) != token) {
                    return null;
                } else {
                    i_val += token.length;
                }
            }
        }
        // If there are any trailing characters left in the value, it doesn't match
        if (i_val != val.length) {
            return null;
        }
        // Is date valid for month?
        if (month == 2) {
            // Check for leap year
            if (( (year % 4 == 0) && (year % 100 != 0) ) || (year % 400 == 0)) { // leap year
                if (date > 29) {
                    return null;
                }
            } else {
                if (date > 28) {
                    return null;
                }
            }
        }
        if ((month == 4) || (month == 6) || (month == 9) || (month == 11)) {
            if (date > 30) {
                return null;
            }
        }
        // Correct hours value
        if (hh < 12 && ampm == "PM") {
            hh = hh - 0 + 12;
        }
        else if (hh > 11 && ampm == "AM") {
            hh -= 12;
        }
        return new Date(year, month - 1, date, hh, mm, ss);
    };

    var theDate=this._getDate(val, format);
    if (!theDate && lenient){
        //try with short format
        var f=format.replace("MMMM","M").replace("MMM","M").replace("MM","M")
            .replace("yyyy","y").replace("yyy","y").replace("yy","y")
            .replace("dd","d");
        //console.debug("second round with format "+f);
        return this._getDate(val, f);
    } else {
        return theDate;
    }

};

// Check if a date string is valid
Date.isValid = function(val,format,lenient) {
    return (Date.parseString(val,format,lenient) != null);
};

// Check if a date object is before another date object
Date.prototype.isBefore = function(date2) {
    if (date2==null) {
        return false;
    }
    return (this.getTime()<date2.getTime());
};

// Check if a date object is after another date object
Date.prototype.isAfter = function(date2) {
    if (date2==null) {
        return false;
    }
    return (this.getTime()>date2.getTime());
};

// Check if two date objects have equal dates and times
Date.prototype.equals = function(date2) {
    if (date2==null) {
        return false;
    }
    return (this.getTime()==date2.getTime());
};

// Check if two date objects have equal dates, disregarding times
Date.prototype.equalsIgnoreTime = function(date2) {
    if (date2==null) {
        return false;
    }
    var d1 = new Date(this.getTime()).clearTime();
    var d2 = new Date(date2.getTime()).clearTime();
    return (d1.getTime()==d2.getTime());
};

/**
 * Get week number in the year.
 */
Date.prototype.getWeekNumber = function() {
    var d = new Date(+this);
    d.setHours(0,0,0,0);
    d.setDate(d.getDate()+4-(d.getDay()||7));
    return Math.ceil((((d-new Date(d.getFullYear(),0,1))/8.64e7)+1)/7);
};

// Format a date into a string using a given format string
Date.prototype.format = function(format) {
    if (!format)
        format=Date.defaultFormat;
    format=format+"";
    var result="";
    var i_format=0;
    var c="";
    var token="";
    var y=this.getFullYear()+"";
    var M=this.getMonth()+1;
    var d=this.getDate();
    var E=this.getDay();
    var H=this.getHours();
    var m=this.getMinutes();
    var s=this.getSeconds();
    var w=this.getWeekNumber();
    // Convert real date parts into formatted versions
    var value=new Object();
    if (y.length < 4) {
        y=""+(+y+1900);
    }
    value["y"]=""+y;
    value["yyyy"]=y;
    value["yy"]=y.substring(2,4);
    value["M"]=M;
    value["MM"]=Date.LZ(M);
    value["MMM"]=Date.monthAbbreviations[M-1];
    value["MMMM"]=Date.monthNames[M-1];
    value["d"]=d;
    value["dd"]=Date.LZ(d);
    value["E"]=Date.dayAbbreviations[E];
    value["EE"]=Date.dayAbbreviations[E];
    value["EEE"]=Date.dayAbbreviations[E];
    value["EEEE"]=Date.dayNames[E];
    value["H"]=H;
    value["HH"]=Date.LZ(H);
    value["w"]=w;
    value["ww"]=Date.LZ(w);
    if (H==0){
        value["h"]=12;
    }
    else if (H>12){
        value["h"]=H-12;
    }
    else {
        value["h"]=H;
    }
    value["hh"]=Date.LZ(value["h"]);
    value["K"]=value["h"]-1;
    value["k"]=value["H"]+1;
    value["KK"]=Date.LZ(value["K"]);
    value["kk"]=Date.LZ(value["k"]);
    if (H > 11) {
        value["a"]="PM";
    }
    else {
        value["a"]="AM";
    }
    value["m"]=m;
    value["mm"]=Date.LZ(m);
    value["s"]=s;
    value["ss"]=Date.LZ(s);
    while (i_format < format.length) {
        c=format.charAt(i_format);
        token="";
        while ((format.charAt(i_format)==c) && (i_format < format.length)) {
            token += format.charAt(i_format++);
        }
        if (typeof(value[token])!="undefined") {
            result=result + value[token];
        }
        else {
            result=result + token;
        }
    }
    return result;
};

// Get the full name of the day for a date
Date.prototype.getDayName = function() {
    return Date.dayNames[this.getDay()];
};

// Get the abbreviation of the day for a date
Date.prototype.getDayAbbreviation = function() {
    return Date.dayAbbreviations[this.getDay()];
};

// Get the full name of the month for a date
Date.prototype.getMonthName = function() {
    return Date.monthNames[this.getMonth()];
};

// Get the abbreviation of the month for a date
Date.prototype.getMonthAbbreviation = function() {
    return Date.monthAbbreviations[this.getMonth()];
};

// Clear all time information in a date object
Date.prototype.clearTime = function() {
    this.setHours(0);
    this.setMinutes(0);
    this.setSeconds(0);
    this.setMilliseconds(0);
    return this;
};

// Add an amount of time to a date. Negative numbers can be passed to subtract time.
Date.prototype.add = function(interval, number) {
    if (typeof(interval)=="undefined" || interval==null || typeof(number)=="undefined" || number==null) {
        return this;
    }
    number = +number;
    if (interval=='y') { // year
        this.setFullYear(this.getFullYear()+number);
    } else if (interval=='M') { // Month
        this.setMonth(this.getMonth()+number);
    }	else if (interval=='d') { // Day
        this.setDate(this.getDate()+number);
    }	else if (interval=='w') { // Week
        this.setDate(this.getDate()+number*7);
    }	else if (interval=='h') { // Hour
        this.setHours(this.getHours() + number);
    }	else if (interval=='m') { // Minute
        this.setMinutes(this.getMinutes() + number);
    }	else if (interval=='s') { // Second
        this.setSeconds(this.getSeconds() + number);
    }
    return this;

};

Date.prototype.toInt = function () {
    return this.getFullYear()*10000+(this.getMonth()+1)*100+this.getDate();
};

Date.fromInt=function (dateInt){
    var year = parseInt(dateInt/10000);
    var month = parseInt((dateInt-year*10000)/100);
    var day = parseInt(dateInt-year*10000-month*100);
    return new Date(year,month-1,day,12,00,00);
};


Date.prototype.isHoliday=function(){
    return isHoliday(this);
};

Date.prototype.isToday=function(){
    return this.toInt()==new Date().toInt();
};


Date.prototype.incrementDateByWorkingDays=function (days) {
    //console.debug("incrementDateByWorkingDays start ",d,days)
    var q = Math.abs(days);
    while (q > 0) {
        this.setDate(this.getDate() + (days > 0 ? 1 : -1));
        if (!this.isHoliday())
            q--;
    }
    return this;
};


Date.prototype.distanceInDays= function (toDate){
    // Discard the time and time-zone information.
    var utc1 = Date.UTC(this.getFullYear(), this.getMonth(), this.getDate());
    var utc2 = Date.UTC(toDate.getFullYear(), toDate.getMonth(), toDate.getDate());
    return Math.floor((utc2 - utc1) / (3600000*24));
};

//low performances in case of long distance
/*Date.prototype.distanceInWorkingDays= function (toDate){
 var pos = new Date(this.getTime());
 pos.setHours(23, 59, 59, 999);
 var days = 0;
 var nd=new Date(toDate.getTime());
 nd.setHours(23, 59, 59, 999);
 var end=nd.getTime();
 while (pos.getTime() <= end) {
 days = days + (isHoliday(pos) ? 0 : 1);
 pos.setDate(pos.getDate() + 1);
 }
 return days;
 };*/

//low performances in case of long distance
// bicch 22/4/2016: modificato per far ritornare anche valori negativi, così come la controparte Java in CompanyCalendar.
// attenzione che prima tornava 1 per due date uguali adesso torna 0
Date.prototype.distanceInWorkingDays= function (toDate){
    var pos = new Date(Math.min(this,toDate));
    pos.setHours(12, 0, 0, 0);
    var days = 0;
    var nd=new Date(Math.max(this,toDate));
    nd.setHours(12, 0,0, 0);
    while (pos < nd) {
        days = days + (isHoliday(pos) ? 0 : 1);
        pos.setDate(pos.getDate() + 1);
    }
    days=days*(this>toDate?-1:1);

    //console.debug("distanceInWorkingDays",this,toDate,days);
    return days;
};

Date.prototype.setFirstDayOfThisWeek= function (firstDayOfWeek){
    if (!firstDayOfWeek)
        firstDayOfWeek=Date.firstDayOfWeek;
    this.setDate(this.getDate() - this.getDay() +firstDayOfWeek - (this.getDay()==0 && firstDayOfWeek!=0 ?7:0));
    return this;
};


/* ----- millis format --------- */
/**
 * @param         str         - Striga da riempire
 * @param         len         - Numero totale di caratteri, comprensivo degli "zeri"
 * @param         ch          - Carattere usato per riempire
 */

function pad(str, len, ch) {
    if ((str + "").length < len) {
        return new Array(len - ('' + str).length + 1).join(ch) + str;
    } else {
        return str
    }
}

function getMillisInHours(millis) {
    if (!millis)
        return "";
    var hour = Math.floor(millis / 3600000);
    return  ( millis >= 0 ? "" : "-") + pad(hour, 1, "0");
}
function getMillisInHoursMinutes(millis) {
    if (typeof(millis) != "number")
        return "";

    var sgn = millis >= 0 ? 1 : -1;
    millis = Math.abs(millis);
    var hour = Math.floor(millis / 3600000);
    var min = Math.floor((millis % 3600000) / 60000);
    return  (sgn > 0 ? "" : "-") + pad(hour, 1, "0") + ":" + pad(min, 2, "0");
}

function getMillisInDaysHoursMinutes(millis) {
    if (!millis)
        return "";
    // millisInWorkingDay is set on partHeaderFooter
    var sgn = millis >= 0 ? 1 : -1;
    millis = Math.abs(millis);
    var days = Math.floor(millis / millisInWorkingDay);
    var hour = Math.floor((millis % millisInWorkingDay) / 3600000);
    var min = Math.floor((millis - days * millisInWorkingDay - hour * 3600000) / 60000);
    return (sgn >= 0 ? "" : "-") + (days > 0 ? days + "  " : "") + pad(hour, 1, "0") + ":" + pad(min, 2, "0");
}

function millisFromHourMinute(stringHourMinutes) { //All this format are valid: "12:58" "13.75"  "63635676000" (this is already in milliseconds)
    var result = 0;
    stringHourMinutes.replace(",", ".");
    var semiColSeparator = stringHourMinutes.indexOf(":");
    var dotSeparator = stringHourMinutes.indexOf(".");

    if (semiColSeparator < 0 && dotSeparator < 0 && stringHourMinutes.length > 5) {
        return parseInt(stringHourMinutes, 10); //already in millis
    } else {

        if (dotSeparator > -1) {
            var d = parseFloat(stringHourMinutes);
            result = d * 3600000;
        } else {
            var hour = 0;
            var minute = 0;
            if (semiColSeparator == -1)
                hour = parseInt(stringHourMinutes, 10);
            else {
                hour = parseInt(stringHourMinutes.substring(0, semiColSeparator), 10);
                minute = parseInt(stringHourMinutes.substring(semiColSeparator + 1), 10);
            }
            result = hour * 3600000 + minute * 60000;
        }
        if (typeof(result) != "number")
            result = NaN;
        return result;
    }
}


/**
 * @param string              "3y 4d", "4D:08:10", "12M/3d", "1.5D", "2H4D", "3M4d,2h", "12:30", "11", "3", "1.5", "2m/3D", "12/3d", "1234"
 *                            by default 2 means 2 hours 1.5 means 1:30
 * @param considerWorkingdays if true day length is from global.properties CompanyCalendar.MILLIS_IN_WORKING_DAY  otherwise in 24
 * @return milliseconds. 0 if invalid string
 */
function millisFromString(string, considerWorkingdays) {
    if (!string)
        return 0;

    //var regex = new RegExp("(\\d+[Yy])|(\\d+[M])|(\\d+[Ww])|(\\d+[Dd])|(\\d+[Hh])|(\\d+[m])|(\\d+[Ss])|(\\d+:\\d+)|(:\\d+)|(\\d*[\\.,]\\d+)|(\\d+)", "g"); // bicch 14/1/16 supporto per 1.5d
    var regex = new RegExp("([0-9\\.,]+[Yy])|([0-9\\.,]+[M])|([0-9\\.,]+[Ww])|([0-9\\.,]+[Dd])|([0-9\\.,]+[Hh])|([0-9\\.,]+[m])|([0-9\\.,]+[Ss])|(\\d+:\\d+)|(:\\d+)|(\\d*[\\.,]\\d+)|(\\d+)", "g");

    var matcher = regex.exec(string);
    var totMillis = 0;

    if (!matcher)
        return NaN;

    while (matcher != null) {
        for (var i = 1; i < matcher.length; i++) {
            var match = matcher[i];
            if (match) {
                var number = 0;
                try {
                    //number = parseInt(match); // bicch 14/1/16 supporto per 1.5d
                    number = parseFloat(match.replace(',','.'));
                } catch (e) {
                }
                if (i == 1) { // years
                    totMillis = totMillis + number * (considerWorkingdays ? millisInWorkingDay * workingDaysPerWeek * 52 : 3600000 * 24 * 365);
                } else if (i == 2) { // months
                    totMillis = totMillis + number * (considerWorkingdays ? millisInWorkingDay * workingDaysPerWeek * 4 : 3600000 * 24 * 30);
                } else if (i == 3) { // weeks
                    totMillis = totMillis + number * (considerWorkingdays ? millisInWorkingDay * workingDaysPerWeek : 3600000 * 24 * 7);
                } else if (i == 4) { // days
                    totMillis = totMillis + number * (considerWorkingdays ? millisInWorkingDay : 3600000 * 24);
                } else if (i == 5) { // hours
                    totMillis = totMillis + number * 3600000;
                } else if (i == 6) { // minutes
                    totMillis = totMillis + number * 60000;
                } else if (i == 7) { // seconds
                    totMillis = totMillis + number * 1000;
                } else if (i == 8) { // hour:minutes
                    totMillis = totMillis + millisFromHourMinute(match);
                } else if (i == 9) { // :minutes
                    totMillis = totMillis + millisFromHourMinute(match);
                } else if (i == 10) { // hour.minutes
                    totMillis = totMillis + millisFromHourMinute(match);
                } else if (i == 11) { // hours
                    totMillis = totMillis + number * 3600000;
                }
            }
        }
        matcher = regex.exec(string);
    }

    return totMillis;
}

/**
 * @param string              "3y 4d", "4D:08:10", "12M/3d", "2H4D", "3M4d,2h", "12:30", "11", "3", "1.5", "2m/3D", "12/3d", "1234"
 *                            by default 2 means 2 hours 1.5 means 1:30
 * @param considerWorkingdays if true day length is from global.properties CompanyCalendar.MILLIS_IN_WORKING_DAY  otherwise in 24
 * @return milliseconds. 0 if invalid string
 */
function daysFromString(string, considerWorkingdays) {
    if (!string)
        return undefined;

    //var regex = new RegExp("(\\d+[Yy])|(\\d+[Mm])|(\\d+[Ww])|(\\d+[Dd])|(\\d*[\\.,]\\d+)|(\\d+)", "g"); // bicch 14/1/16 supporto per 1.5d
    var regex = new RegExp("([0-9\\.,]+[Yy])|([0-9\\.,]+[Mm])|([0-9\\.,]+[Ww])|([0-9\\.,]+[Dd])|(\\d*[\\.,]\\d+)|(\\d+)", "g");

    var matcher = regex.exec(string);
    var totDays = 0;

    if (!matcher)
        return NaN;

    while (matcher != null) {
        for (var i = 1; i < matcher.length; i++) {
            var match = matcher[i];
            if (match) {
                var number = 0;
                try {
                    number = parseInt(match);// bicch 14/1/16 supporto per 1.5d
                    number = parseFloat(match.replace(',','.'));
                } catch (e) {
                }
                if (i == 1) { // years
                    totDays = totDays + number * (considerWorkingdays ? workingDaysPerWeek * 52 : 365);
                } else if (i == 2) { // months
                    totDays = totDays + number * (considerWorkingdays ? workingDaysPerWeek * 4 : 30);
                } else if (i == 3) { // weeks
                    totDays = totDays + number * (considerWorkingdays ? workingDaysPerWeek : 7);
                } else if (i == 4) { // days
                    totDays = totDays + number;
                } else if (i == 5) { // days.minutes
                    totDays = totDays + number;
                } else if (i == 6) { // days
                    totDays = totDays + number;
                }
            }
        }
        matcher = regex.exec(string);
    }

    return parseInt(totDays);
}





/*
 Copyright (c) 2012-2017 Open Lab
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

function centerPopup(url, target, w, h, scroll, resiz) {
    var winl = (screen.width - w) / 2;
    var wint = (screen.height - h) / 2;
    var winprops = 'height=' + h + ',width=' + w + ',top=' + wint + ',left=' + winl + ',scrollbars=' + scroll + ',resizable=' + resiz + ', toolbars=false, status=false, menubar=false';
    var win = window.open(url, target, winprops);
    if (!win)
        alert("A popup blocker was detected: please allow them for this application (check out the upper part of the browser window).");
    if (parseInt(navigator.appVersion) >= 4) {
        win.window.focus();
    }
}

function openCenteredWindow(url, target, winprops) {
    var prop_array = winprops.split(",");
    var i = 0;
    var w = 800;
    var h = 600;
    if (winprops && winprops != '') {
        while (i < prop_array.length) {
            if (prop_array[i].indexOf('width') > -1) {
                s = prop_array[i].substring(prop_array[i].indexOf('=') + 1);
                w = parseInt(s);
            } else if (prop_array[i].indexOf('height') > -1) {
                s = prop_array[i].substring(prop_array[i].indexOf('=') + 1);
                h = parseInt(s);
            }
            i += 1;
        }
        var winl = (screen.width - w) / 2;
        var wint = (screen.height - h) / 2;
        winprops = winprops + ",top=" + wint + ",left=" + winl;
    }
    win = window.open(url, target, winprops);
    if (!win)
        alert("A popup blocker was detected: please allow them for this application (check out the upper part of the browser window).");
    if (parseInt(navigator.appVersion) >= 4) {
        win.window.focus();
    }
}

function showFeedbackMessage(typeOrObject, message, title, autoCloseTime) {

    if(!autoCloseTime)
        autoCloseTime = 0;

    //console.debug("showFeedbackMessage",typeOrObject, message, title);
    var place = $("#__FEEDBACKMESSAGEPLACE");
    var mess;
    if (typeof(typeOrObject)=="object" )
        mess=typeOrObject;
    else
        mess = {type:typeOrObject, message:message,title:title};
    //if exists append error message
    var etm = $(".FFC_"+mess.type+":visible ._errorTemplateMessage");
    if(etm.length>0){
        etm.append("<hr>"+(mess.title?"<b>"+mess.title+"</b><br>":"")+mess.message+"<br>");
    }else{
        etm = $.JST.createFromTemplate(mess, "errorTemplate");
        place.append(etm);
        place.fadeIn();
    }

    if(autoCloseTime >0)
        setTimeout(function(){
            etm.fadeOut();
        },autoCloseTime);

    $(".FFC_OK").stopTime("ffchide").oneTime(1500, "ffchide",function () {$(this).fadeOut(400,function(){$(this)})});
    $(".FFC_WARNING").stopTime("ffchide").oneTime(75000, "ffchide",function () {$(this).fadeOut(400,function(){$(this)})});
    $(".FFC_ERROR").stopTime("ffchide").oneTime(10000, "ffchide",function () {$(this).fadeOut(400,function(){$(this)})});
}

function showFeedbackMessageInDiv(type, message, divId) {
    var place = $("#" + divId);
    var mess = {type:type, message:message};
    place.prepend($.JST.createFromTemplate(mess, "errorTemplate"));
    place.fadeIn();
    $("body").oneTime(1200, function () {
        $(".FFC_OK").fadeOut();
    });
}
function hideFeedbackMessages() {
    $("#__FEEDBACKMESSAGEPLACE").empty();
}


function submitInBlack(formId, actionHref, w, h) {

    if (!w)
        w = $(window).width() - 100;
    if (!h)
        h = $(window).height() - 50;

    openBlackPopup('', w + "px", h + "px", null, formId + "_ifr");
    var form = $("#" + formId);
    var oldAction = form.prop("action");
    var oldTarget = form.prop("target");
    form.prop("action", actionHref);
    form.prop("target", formId + "_ifr");
    $(window).data("openerForm", form);
    form.submit();
    form.prop("action", oldAction);
    if (oldTarget)
        form.prop("target", oldTarget);
    else
        form.removeAttr("target");
}


var __popups = [];
function createModalPopup(width, height, onCloseCallBack, cssClass, element, popupOpener) {
    //console.debug("createModalPopup");


    if (typeof(disableUploadize)=="function")
        disableUploadize();

    // se non diversamenete specificato l'openere è la window corrente;
    popupOpener = popupOpener || window;

    if (!width)
        width = "80%";

    if (!height)
        height = "80%";

    var localWidth=width,localHeight=height;

    if (typeof (width)=="string" && width.indexOf("%")>0 ) {
        localWidth = function () {return ($(window).width() * parseFloat(width)) / 100};
    }

    if (typeof (height)=="string" && height.indexOf("%")>0)
        localHeight = function(){return ($(window).height() *  parseFloat(height)) / 100};

    var popupWidth = localWidth, popupHeight = localHeight;

    if(typeof localWidth == "function")
        popupWidth = localWidth();

    if(typeof localHeight == "function")
        popupHeight = localHeight();

    popupWidth = parseFloat(popupWidth);
    popupHeight = parseFloat(popupHeight);

    if (typeof onCloseCallBack == "string")
        cssClass = onCloseCallBack;

    //$("#__popup__").remove();

    var popupN = __popups.length+1;
    __popups.push("__popup__" + popupN);

    var isInIframe = isIframe();

    var bg = $("<div>").prop("id", "__popup__" + popupN);
    bg.addClass("modalPopup" + (isInIframe ? " inIframe" : "")).hide();

    if (cssClass)
        bg.addClass(cssClass);

    function getMarginTop(){
        var mt = ($(window).height() - popupHeight)/2 - 100;
        return mt < 0 ? 10 : mt;
    }

    var internalDiv=$("<div>").addClass("bwinPopupd").css({ width:popupWidth, minHeight:popupHeight, marginTop: getMarginTop(), maxHeight:$(window).height()-20, overflow: "auto" });

    $(window).off("resize.popup"+popupN).on("resize.popup"+popupN, function(){

        if(typeof localWidth == "function")
            popupWidth = localWidth();

        if(typeof localHeight == "function")
            popupHeight = localHeight();

        internalDiv.css({ width:popupWidth, minHeight:popupHeight });

        var w = internalDiv.outerWidth() > $(window).width()-20 ? $(window).width()-20 : popupWidth;
        var h = internalDiv.outerHeight() > $(window).height()-20 ? $(window).height()-20 : popupHeight;

        internalDiv.css({ marginTop: getMarginTop(), minHeight: h, maxHeight:$(window).height()-20,minWidth: w });

    });

    bg.append(internalDiv);

    var showBG = function(el, time, callback){

        if (isInIframe) {
            internalDiv.css({marginTop: -50 });
            el.show();
            internalDiv.animate({marginTop: 0}, (time/2), callback);
        } else {
            internalDiv.css({opacity: 0, top: -50}).show();
            el.fadeIn(time, function () {
                internalDiv.animate({top: 0, opacity: 1}, time/3, callback);
            });
        }

        /*
         if(isInIframe) {
         internalDiv.css({marginTop: -1000 });
         el.show();
         internalDiv.animate({marginTop: 0}, (time * 2), callback);
         }else{
         internalDiv.css({opacity:0, top: -500}).show();
         el.fadeIn(time, function(){
         internalDiv.animate({top: 0, opacity:1}, time, callback);
         });
         }
         */

        return this;
    };

    if(!element)
        $("#twMainContainer").addClass("blur");

    showBG(bg, 300, function(){})
    bg.on("click",function(event){
        if ($(event.target).closest(".bwinPopupd").length <= 0)
            bg.trigger("close");
    });

    var close = $("<span class=\"teamworkIcon close popUpClose\" style='cursor:pointer;position:absolute;'>x</span>");
    internalDiv.append(close);

    close.click(function () {
        bg.trigger("close");
    });

    $("body").css({overflowY:"hidden"});

    if(!element){
        $("body").append(bg);
    }else{
        element.after(bg);
    }

    //close call callback
    bg.on("close", function () {
        var callBackdata = $(this).data("callBackdata");
        var ndo=bg;

        if (typeof (enableUploadize)=="function")
            enableUploadize();

        //console.debug("ndo",ndo);

        var alertMsg;
        var ifr=bg.find("iframe");

        if (ifr.length>0){
            try {
                alertMsg = ifr.get(0).contentWindow.alertOnUnload();
            }catch (e){}
        } else {
            alertMsg=alertOnUnload(ndo);
        }

        if (alertMsg){
            if (!confirm(alertMsg))
                return;
        }

        bg.fadeOut(100, function () {

            $(window).off("resize.popup"+popupN);
            bg.remove();
            __popups.pop();

            if (__popups.length == 0)
                $("#twMainContainer").removeClass("blur");

            if (typeof(onCloseCallBack) == "function")
                onCloseCallBack(callBackdata);

            $("body").css({overflowY: "auto"});
        });

    });

    //destroy do not call callback
    bg.on("destroy", function () {
        bg.remove();
        $("body").css({overflowY: "auto"});
    });

    //rise resize event in order to show buttons
    $("body").oneTime(1000,"br",function(){$(this).resize();}); // con meno di 1000 non funziona


    //si deposita l'popupOpener sul bg. Per riprenderlo si usa getBlackPopupOpener()
    bg.data("__opener",popupOpener);

    return internalDiv;
}

function changeModalSize(w,h){
    var newDim = {};
    if(w)
        newDim.width = w;
    if(h)
        newDim.minHeight = h;

    var isInIframe = isIframe();
    var popUp = isInIframe ? window.parent.$(".bwinPopupd") : $(".bwinPopupd");

    if(popUp.length)
        popUp.delay(300).animate(newDim, 200);
}

function openBlackPopup(url, width, height, onCloseCallBack, iframeId, cssClass) {

    if (!iframeId)
        iframeId = "bwinPopupIframe";

    //add black only if not already in blackpupup
    var color= cssClass ? cssClass + " iframe" : "iframe";

    var ndo = top.createModalPopup(width, height, onCloseCallBack, color,null,window);

    //ndo.closest(".modalPopup ").data("__opener",window);  // si deposita il vero opener

    var isInIframe = isIframe();

    ndo.append("<div class='bwinPopupIframe_wrapper'><iframe id='" + iframeId + "' name='" + iframeId + "' frameborder='0'></iframe></div>");
    ndo.find("iframe:first").prop("src", url).css({width:"100%", height:"100%", backgroundColor: isInIframe ? '#F9F9F9' : '#FFFFFF'});
}

function getBlackPopup() {
    var ret=$([]);
    if (__popups.length>0) {
        var id = __popups[__popups.length - 1];
        ret = $("#" + id);
    }
    if (ret.length==0 && window!=top) {
        ret = window.parent.getBlackPopup();
    }
    return ret;
}


function getBlackPopupOpener(){
    return getBlackPopup().data("__opener")
}

function closeBlackPopup(callBackdata) {
    //console.debug("closeBlackPopup ",callBackdata);
    var bp = getBlackPopup();

    if (callBackdata)
        bp.data("callBackdata",callBackdata);
    bp.trigger("close");
}

function openPopUp(el,width,height){
    var popup=createModalPopup(width,height);
    popup.append(el.clone().show());
}

//returns a jquery object where to write content

function isIframe() {
    var isIframe = false;
    try{
        //try to access the document object
        if (self.location.href != top.location.href)
            isIframe = true;
    }catch(e) {
        //We don't have access, it's cross-origin!
        isIframe = true;
    }
    return isIframe;
};


function openBulkAction(bulkDivId){
    var popup=createModalPopup(500,300);
    popup.append($("#"+bulkDivId).clone().show());
}


function refreshBulk(el) {
    //console.debug("refreshBulk")

    if (el.is(":checked"))
        el.closest("tr").addClass("selected");
    else
        el.closest("tr").removeClass("selected");

    var table=el.closest(".dataTable");
    if (table.find(".selected :checked").length > 0) {

        $("#bulkOp #bulkRowSel").html(table.find("tbody > tr.selected").length + "/" + table.children("tbody").children("tr").length);

        var bukOpt = $("#bulkOp").clone().addClass("bulkOpClone");
        bukOpt.fadeIn(200, function(){
            $("#bulkPlace").html(bukOpt);
            $.tableHF.refreshTfoot();
        });

    } else {
        $(".bulkOpClone").fadeOut(200, function(){
            $.tableHF.refreshTfoot();
        });
    }
}

function selUnselAll(el){
    //var bulkCheckbox = $("#multi td [type='checkbox']");
    var bulkCheckbox = el.closest(".dataTable").find("[type='checkbox']");
    if (el.is(":checked")){
        bulkCheckbox.prop("checked", true);
        bulkCheckbox.closest("tr").addClass("selected");
    } else {
        bulkCheckbox.prop("checked", false);
        bulkCheckbox.closest("tr").removeClass("selected");
    }

    refreshBulk(el);
}







/*
 Copyright (c) 2012-2017 Open Lab
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

//----------------------------------positioning-----------------------------------------------
jQuery.fn.centerOnScreen = function () {
    return this.each(function () {
        var container = $(this);
        //console.debug($(window).height(), container.outerHeight(),(($(window).height() - container.outerHeight()) / 2))
        container.css("position", "fixed");
        container.css("top", (($(window).height() - container.outerHeight()) / 2) + 'px');
        container.css("left", (($(window).width() - container.outerWidth()) / 2) + 'px');
    });
};


function nearBestPosition(whereId, theObjId, centerOnEl) {

    var el = whereId;
    var target = theObjId;

    if (typeof whereId != "object") {
        el = $("#" + whereId);
    }
    if (typeof theObjId != "object") {
        target = $("#" + theObjId);
    }

    if (el) {
        target.css("visibility", "hidden");
        var hasContainment = false;

        target.parents().each(function () {
            if ($(this).css("position") == "static")
                return;

            hasContainment = true;
        });

        var trueX = hasContainment ? el.position().left : el.offset().left;
        var trueY = hasContainment ? el.position().top : el.offset().top;
        var h = el.outerHeight();
        var elHeight = parseFloat(h);

        if (centerOnEl) {
            var elWidth = parseFloat(el.outerWidth());
            var targetWidth = parseFloat(target.outerWidth());
            trueX += (elWidth - targetWidth) / 2;
        }

        trueY += parseFloat(elHeight);

        var left = trueX;
        var top = trueY;
        var barHeight = 45 ;
        var barWidth =  20 ;

        if (trueX && trueY) {
            target.css("left", left);
            target.css("top", top);
        }

        if (target.offset().left >= ( ($(window).width() + $(window).scrollLeft()) - target.outerWidth())) {

            left = ( ($(window).width() + $(window).scrollLeft()) - target.outerWidth() - 10 );
            target.css({left:left, marginTop: 0});
        }

        if (target.offset().left < 0) {
            left = 10;
            target.css("left", left);
        }

        if ((target.offset().top + target.outerHeight() >= ( ($(window).height() + $(window).scrollTop()) - barHeight)) && (target.outerHeight() < $(window).height())) {
            var marginTop = -(target.outerHeight() + el.outerHeight());
            target.css("margin-top", marginTop);
        }

        if (target.offset().top < 0) {
            top = 0;
            target.css("top", top);
        }


        target.css("visibility", "visible");
    }
}

$.fn.keepItVisible = function (ref) {
    var thisTop = $(this).offset().top;
    var thisLeft = $(this).offset().left;
    var fromTop =0;
    var fromLeft =0;

    var windowH =  $(window).height() + $(window).scrollTop();
    var windowW =  $(window).width() + $(window).scrollLeft();

    if (ref){
        fromTop = windowH - (ref.offset().top);
        fromLeft = windowW -  (ref.offset().left + ref.outerWidth());
    }

    if (thisTop + $(this).outerHeight() > windowH){
        var mt = (thisTop + $(this).outerHeight()) - windowH;
//		$(this).css("margin-top", -$(this).outerHeight() - fromTop);
        $(this).css("margin-top", -mt - fromTop);
    }
    if (thisLeft + $(this).outerWidth() > windowW){
        var mL = (thisLeft + $(this).outerWidth()) - windowW;
//		$(this).css("margin-left", -$(this).outerWidth() - fromLeft);
        $(this).css("margin-left", -mL - fromLeft);
    }
    $(this).css("visibility", "visible");
};

//END positioning


/*   Caret Functions
 Use setSelection with start = end to set caret
 */
function setSelection(input, start, end) {
    input.setSelectionRange(start, end);
}

$.fn.setCursorPosition = function(pos) {
    this.each(function(index, elem) {
        if (elem.setSelectionRange) {
            elem.setSelectionRange(pos, pos);
        } else if (elem.createTextRange) {
            var range = elem.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    });
    return this;
};

//-- Caret Functions END ---------------------------------------------------------------------------- --



/*----------------------------------------------------------------- manage bbButtons*/
$.buttonBar = {
    defaults: {},

    init: function(){
        setTimeout(function(){
            $.buttonBar.manageButtonBar();
        },100);

        $(window).on("scroll.ButtonBar",function(){
            $.buttonBar.manageButtonBar();
        });
        $(window).on("resize.ButtonBar",function(){
            $.buttonBar.manageButtonBar();
        });
    },

    manageButtonBar: function(anim) {

        $(".buttonArea").not(".bbCloned").not(".notFix").each(function(){
            var bb = this;

            //se usiamo questi si rompe la button bar flottante del save sulla issue list
            //bb.originalHeigh=bb.originalHeigh ||  $(bb).height();
            //bb.originalOffsetTop=bb.originalOffsetTop||$(bb).offset().top;

            bb.originalHeigh= $(bb).height();
            bb.originalOffsetTop=$(bb).offset().top;

            bb.isOut = $(window).scrollTop() + $(window).height() - bb.originalHeigh < bb.originalOffsetTop;

            if (bb.bbHolder)
                bb.bbHolder.css({width: $(bb).outerWidth(),left:$(bb).offset().left});

            if (bb.isOut && !bb.isCloned){
                if (bb.bbHolder)
                    bb.bbHolder.remove();
                bb.isCloned = true;
                bb.bbHolder = $(bb).clone().addClass("bbCloned clone bottom").css({width: $(bb).outerWidth(), marginTop:0,left:$(bb).offset().left});
                bb.bbHolder.hide();
                bb.bbHolder.css({position:"fixed", bottom:0, left:$(bb).offset().left});
                $(bb).after(bb.bbHolder);
                bb.bbHolder.show();
                $(bb).css("visibility","hidden");

            } else if (!bb.isOut && bb.isCloned) {
                //} else {
                bb.isCloned = false;
                bb.bbHolder.remove();
                $(bb).css("visibility","visible");
            }
        });
    },

    refreshButtonBar: function() {
        $(".bbCloned").remove();
        $(".buttonArea").not(".bbCloned").each(function(){
            var bb = this;
            bb.isCloned = false;
        });

        $.buttonBar.manageButtonBar(false);
    }
};





/*
 Copyright (c) 2012-2017 Open Lab
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */


function dateToRelative(localTime){
    var diff=new Date().getTime()-localTime;
    var ret="";

    var min=60000;
    var hour=3600000;
    var day=86400000;
    var wee=604800000;
    var mon=2629800000;
    var yea=31557600000;

    if (diff<-yea*2)
        ret ="in ## years".replace("##",(-diff/yea).toFixed(0));

    else if (diff<-mon*9)
        ret ="in ## months".replace("##",(-diff/mon).toFixed(0));

    else if (diff<-wee*5)
        ret ="in ## weeks".replace("##",(-diff/wee).toFixed(0));

    else if (diff<-day*2)
        ret ="in ## days".replace("##",(-diff/day).toFixed(0));

    else if (diff<-hour)
        ret ="in ## hours".replace("##",(-diff/hour).toFixed(0));

    else if (diff<-min*35)
        ret ="in about one hour";

    else if (diff<-min*25)
        ret ="in about half hour";

    else if (diff<-min*10)
        ret ="in some minutes";

    else if (diff<-min*2)
        ret ="in few minutes";

    else if (diff<=min)
        ret ="just now";

    else if (diff<=min*5)
        ret ="few minutes ago";

    else if (diff<=min*15)
        ret ="some minutes ago";

    else if (diff<=min*35)
        ret ="about half hour ago";

    else if (diff<=min*75)
        ret ="about an hour ago";

    else if (diff<=hour*5)
        ret ="few hours ago";

    else if (diff<=hour*24)
        ret ="## hours ago".replace("##",(diff/hour).toFixed(0));

    else if (diff<=day*7)
        ret ="## days ago".replace("##",(diff/day).toFixed(0));

    else if (diff<=wee*5)
        ret ="## weeks ago".replace("##",(diff/wee).toFixed(0));

    else if (diff<=mon*12)
        ret ="## months ago".replace("##",(diff/mon).toFixed(0));

    else
        ret ="## years ago".replace("##",(diff/yea).toFixed(0));

    return ret;
}

//override date format i18n

Date.monthNames = ["January","February","March","April","May","June","July","August","September","October","November","December"];
// Month abbreviations. Change this for local month names
Date.monthAbbreviations = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
// Full day names. Change this for local month names
Date.dayNames =["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
// Day abbreviations. Change this for local month names
Date.dayAbbreviations = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];
// Used for parsing ambiguous dates like 1/2/2000 - default to preferring 'American' format meaning Jan 2.
// Set to false to prefer 'European' format meaning Feb 1
Date.preferAmericanFormat = false;

Date.firstDayOfWeek =0;
Date.defaultFormat = "M/d/yyyy";
Date.masks = {
    fullDate:       "EEEE, MMMM d, yyyy",
    shortTime:      "h:mm a"
};
Date.today="Today";

Number.decimalSeparator = ".";
Number.groupingSeparator = ",";
Number.minusSign = "-";
Number.currencyFormat = "###,##0.00";



var millisInWorkingDay =28800000;
var workingDaysPerWeek =5;

function isHoliday(date) {
    var friIsHoly =false;
    var satIsHoly =true;
    var sunIsHoly =true;

    var pad = function (val) {
        val = "0" + val;
        return val.substr(val.length - 2);
    };

    var holidays = "##";

    var ymd = "#" + date.getFullYear() + "_" + pad(date.getMonth() + 1) + "_" + pad(date.getDate()) + "#";
    var md = "#" + pad(date.getMonth() + 1) + "_" + pad(date.getDate()) + "#";
    var day = date.getDay();

    return  (day == 5 && friIsHoly) || (day == 6 && satIsHoly) || (day == 0 && sunIsHoly) || holidays.indexOf(ymd) > -1 || holidays.indexOf(md) > -1 || (holidaysForGantt.indexOf(md) !== -1);
}



var i18n = {
    YES:                 "Yes",
    NO:                  "No",
    FLD_CONFIRM_DELETE:  "confirm the deletion?",
    INVALID_DATA:        "The data inserted are invalid for the field format.",
    ERROR_ON_FIELD:      "Error on field",
    OUT_OF_BOUDARIES:      "Out of field admitted values:",
    CLOSE_ALL_CONTAINERS:"close all?",
    DO_YOU_CONFIRM:      "Do you confirm?",
    ERR_FIELD_MAX_SIZE_EXCEEDED:      "Field max size exceeded",
    WEEK_SHORT:      "W.",

    FILE_TYPE_NOT_ALLOWED:"File type not allowed.",
    FILE_UPLOAD_COMPLETED:"File upload completed.",
    UPLOAD_MAX_SIZE_EXCEEDED:"Max file size exceeded",
    ERROR_UPLOADING:"Error uploading",
    UPLOAD_ABORTED:"Upload aborted",
    DROP_HERE:"Drop files here",

    FORM_IS_CHANGED:     "You have some unsaved data on the page!",

    PIN_THIS_MENU: "PIN_THIS_MENU",
    UNPIN_THIS_MENU: "UNPIN_THIS_MENU",
    OPEN_THIS_MENU: "OPEN_THIS_MENU",
    CLOSE_THIS_MENU: "CLOSE_THIS_MENU",
    PROCEED: "Proceed?",

    PREV: "Previous",
    NEXT: "Next",
    HINT_SKIP: "Got it, close this hint.",

    WANT_TO_SAVE_FILTER: "save this filter",
    NEW_FILTER_NAME: "name of the new filter",
    SAVE: "Save",
    DELETE: "Delete",
    HINT_SKIP: "Got it, close this hint.",

    COMBO_NO_VALUES: "no values available...?",

    FILTER_UPDATED:"Filter updated.",
    FILTER_SAVED:"Filter correctly saved."

};




/*
 Copyright (c) 2009 Open Lab
 Written by Roberto Bicchierai http://roberto.open-lab.com
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

jQuery.fn.dateField = function(options) {
    //console.debug("dateField",options);
    //check if the input field is passed correctly
    if (!options.inputField){
        console.error("You must supply an input field");
        return false;
    }

    // --------------------------  start default option values --------------------------

    if (typeof(options.firstDayOfWeek) == "undefined")
        options.firstDayOfWeek=Date.firstDayOfWeek;

    if (typeof(options.useWheel) == "undefined")
        options.useWheel=true;

    if (typeof(options.dateFormat) == "undefined")
        options.dateFormat=Date.defaultFormat;

    if (typeof(options.todayLabel) == "undefined")
        options.todayLabel=Date.today;

    /* optional
     options.notBeforeMillis //disable buttons if before millis
     options.notAfterMillis //disable buttons if after millis
     options.width // imposta una larghezza al calendario
     options.height
     options.showToday // show "today" on the year or month bar
     options.centerOnScreen //se true centra invece che usa nearBestPosition
     options.useYears:0 // se >0 non disegna prev-next ma n anni prima e n anni dopo quello corrente
     options.useMonths:0 // se >0 non disegna prev-next ma n mesi prima e n mesi dopo quello corrente
     */
    // --------------------------  end default option values --------------------------



    // ------------------ start
    if(options.inputField.is("[readonly]") && !options.inputField.is(".noFocus")  || options.inputField.is("[disabled]"))
        return;

    var calendar = {currentDate: new Date()};
    calendar.options = options;

    //build the calendar on the first element in the set of matched elements.
    var theOpener = this.eq(0);
    var theDiv=$("<div>").addClass("calBox");

    if(options.width)
        theDiv.css("width",options.width);

    if(options.height)
        theDiv.css("height",options.height);


    //create calendar elements elements
    var divNavBar = $("<div>").addClass("calNav");
    var divDays = $("<div>").addClass("calDay");

    divDays.addClass("calFullMonth");
    theDiv.append(divNavBar).append(divDays);

    if (options.isSearchField){
        var divShortcuts=$("<div>").addClass("shortCuts").html("<span title='last quarter'>LQ</span> <span title='last month'>LM</span> <span title='this month'>M</span> <span title='last week'>LW</span> <span title='this week'>W</span> <span title='yesterday'>Y</span> <span title='today'>T</span><span title='tomorrow'>TO</span><span title='next week'>NW</span> <span title='next month'>NM</span> <span title='this quarter'>Q</span> <span title='next quarter'>NQ</span>");
        divShortcuts.click(function(ev){
            var el=$(ev.target);
            if(el.is("span")){
                if (!options.isSearchField)
                    options.inputField.val(Date.parseString(el.text().trim(),options.dateFormat,true).format(options.dateFormat));
                else
                    options.inputField.val(el.text().trim());
                calendar.closeCalendar()
            }
        });
        theDiv.append(divShortcuts);
    }

    //mobile management
    if ($("body").is(".mobile")){
        enableComponentOverlay(options.inputField,theDiv);
    }
    $("body").append(theDiv);


    if (options.centerOnScreen){
        theDiv.oneTime(10,"ce",function(){$(this).centerOnScreen()});
    } else {
        nearBestPosition(theOpener,theDiv);
    }
    theDiv.css("z-index",10000);


    //register for click outside. Delayed to avoid it run immediately
    $("body").oneTime(100, "regclibodcal", function() {
        $("body").bind("click.dateField", function() {
            calendar.closeCalendar();
        });
    });


    calendar.drawCalendar = function(date) {
        calendar.currentDate = date;
        //console.debug("drawCalendar",date);


        var fillNavBar = function(date) {
            //console.debug("fillNavBar",date);
            var today = new Date();//today
            divNavBar.empty();

            var showToday = options.showToday;
            //use the classic prev next bar
            if (!options.useYears && !options.useMonths) {
                var t = new Date(date.getTime());
                t.setDate(1);
                t.setMonth(t.getMonth() - 1);
                var spanPrev = $("<span>").addClass("calElement noCallback prev").attr("millis", t.getTime());
                var spanToday = $("<span>").addClass("calElement noCallback goToday").attr("millis", new Date().getTime()).attr("title", "today");
                t.setMonth(t.getMonth() + 1);
                var spanMonth = $("<span>").html(t.format("MMMM yyyy"));
                t.setMonth(t.getMonth() + 1);
                var spanNext = $("<span>").addClass("calElement noCallback next").attr("millis", t.getTime());
                divNavBar.append(spanPrev, spanToday, spanMonth, spanNext);

                // use the year month bar
            } else {
                if (options.useYears>0){
                    options.useMonths=options.useMonths||1; //if shows years -> shows also months
                    t = new Date(date.getTime());
                    var yB= $("<div class='calYear'>");
                    var w=100/(2*options.useYears+1+(showToday?1:0));
                    t.setFullYear(t.getFullYear()-options.useYears);
                    if(showToday){
                        var s = $("<span>").addClass("calElement noCallback goToday").attr("millis", today.getTime()).append(options.todayLabel).css("width",w+"%");
                        showToday=false;
                        yB.append(s);
                    }
                    for (var i=-options.useYears;i<=options.useYears;i++){
                        var s = $("<span>").addClass("calElement noCallback").attr("millis", t.getTime()).append(t.getFullYear()).css("width",w+"%");
                        if (today.getFullYear()== t.getFullYear()) //current year
                            s.addClass("today");
                        if (i==0) //selected year
                            s.addClass("selected");

                        yB.append(s);
                        t.setFullYear(t.getFullYear()+1);
                    }
                    divNavBar.append(yB);
                }
                if (options.useMonths>0){
                    t = new Date(date.getTime());
                    t.setDate(1);
                    var w=100/(2*options.useMonths+1+(showToday?1:0));
                    t.setMonth(t.getMonth()-options.useMonths);
                    var yB= $("<div class='calMonth'>");

                    if(showToday){
                        var s = $("<span>").addClass("calElement noCallback goToday").attr("millis", today.getTime()).append(options.todayLabel).css("width",w+"%");
                        yB.append(s);
                    }

                    for (var i=-options.useMonths;i<=options.useMonths;i++){
                        var s = $("<span>").addClass("calElement noCallback").attr("millis", t.getTime()).append(t.format("MMM")).css("width",w+"%");
                        if (today.getFullYear()== t.getFullYear() && today.getMonth()== t.getMonth()) //current year
                            s.addClass("today");
                        if (i==0) //selected month
                            s.addClass("selected");
                        yB.append(s);
                        t.setMonth(t.getMonth()+1);
                    }
                    divNavBar.append(yB);
                }
            }

        };

        var fillDaysFullMonth = function(date) {
            divDays.empty();
            var today = new Date();//today
            var w = 100/7;
            // draw day headers
            var d = new Date(date);
            d.setFirstDayOfThisWeek(options.firstDayOfWeek);
            for (var i = 0; i < 7; i++) {
                var span = $("<span>").addClass("calDayHeader").attr("day", d.getDay());
                if (d.isHoliday())
                    span.addClass("holy");
                span.css("width",w+"%");
                span.html(Date.dayAbbreviations[d.getDay()]);

                //call the dayHeaderRenderer
                if (typeof(options.dayHeaderRenderer) == "function")
                    options.dayHeaderRenderer(span,d.getDay());

                divDays.append(span);
                d.setDate(d.getDate()+1);
            }

            //draw cells
            d = new Date(date);
            d.setDate(1); // set day to start of month
            d.setFirstDayOfThisWeek(options.firstDayOfWeek);//go to first day of week

            var i=0;

            while ((d.getMonth()<=date.getMonth() && d.getFullYear()<=date.getFullYear()) || d.getFullYear()<date.getFullYear() || (i%7!=0)) {
                var span = $("<span>").addClass("calElement day").attr("millis", d.getTime());

                span.html("<span class=dayNumber>" + d.getDate() + "</span>").css("width",w+"%");
                if (d.getYear() == today.getYear() && d.getMonth() == today.getMonth() && d.getDate() == today.getDate())
                    span.addClass("today");
                if (d.getYear() == date.getYear() && d.getMonth() == date.getMonth() && d.getDate() == date.getDate())
                    span.addClass("selected");

                if (d.isHoliday())
                    span.addClass("holy");

                if(d.getMonth()!=date.getMonth())
                    span.addClass("calOutOfScope");

                //call the dayRenderer
                if (typeof(options.dayRenderer) == "function")
                    options.dayRenderer(span,d);

                divDays.append(span);
                d.setDate(d.getDate()+1);
                i++;
            }

        };

        fillNavBar(date);
        fillDaysFullMonth(date);

        //disable all buttons out of validity period
        if (options.notBeforeMillis ||options.notAfterMillis) {
            var notBefore = options.notBeforeMillis ? options.notBeforeMillis : Number.MIN_VALUE;
            var notAfter = options.notAfterMillis ? options.notAfterMillis : Number.MAX_VALUE;
            divDays.find(".calElement[millis]").each(function(){
                var el=$(this);
                var m=parseInt(el.attr("millis"));
                if (m>notAfter || m<notBefore)
                    el.addClass("disabled");
            })
        }

    };

    calendar.closeCalendar=function(){
        //mobile management
        if ($("body").is(".mobile")){
            disableComponentOverlay();
        }
        theDiv.remove();
        $("body").unbind("click.dateField");
    };

    theDiv.click(function(ev) {
        var el = $(ev.target).closest(".calElement");
        if (el.length > 0) {
            var millis = parseInt(el.attr("millis"));
            var date = new Date(millis);

            if (el.is(".disabled")) {
                ev.stopPropagation();
                return;
            }

            if (el.hasClass("day")) {
                calendar.closeCalendar();
                if (!el.is(".noCallback")) {
                    options.inputField.val(date.format(options.dateFormat)).attr("millis", date.getTime()).focus();
                    if (typeof(options.callback) == "function")
                        options.callback.apply(options.inputField,[date]); // in callBack you can use "this" that refers to the input
                }
            } else {
                calendar.drawCalendar(date);
            }
        }
        ev.stopPropagation();
    });


    //if mousewheel
    if ($.event.special.mousewheel && options.useWheel) {
        divDays.mousewheel(function(event, delta) {
            var d = new Date(calendar.currentDate.getTime());
            d.setMonth(d.getMonth() + delta);
            calendar.drawCalendar(d);
            return false;
        });
    }


    // start calendar to the date in the input
    var dateStr=options.inputField.val();

    if (!dateStr || !Date.isValid(dateStr,options.dateFormat,true)){
        calendar.drawCalendar(new Date());
    } else {
        var date = Date.parseString(dateStr,options.dateFormat,true);
        var newDateStr=date.format(options.dateFormat);
        //set date string formatted if not equals
        if (!options.isSearchField) {
            options.inputField.attr("millis", date.getTime());
            if (dateStr != newDateStr)
                options.inputField.val(newDateStr);
        }
        calendar.drawCalendar(date);
    }

    return calendar;
};




$.fn.loadTemplates = function() {
    $.JST.loadTemplates($(this));
    return this;
};

$.JST = {
    _templates: new Object(),
    _decorators:new Object(),

    loadTemplates: function(elems) {
        elems.each(function() {
            $(this).find(".__template__").each(function() {
                var tmpl = $(this);
                var type = tmpl.attr("type");

                //template may be inside <!-- ... --> or not in case of ajax loaded templates
                var found=false;
                var el=tmpl.get(0).firstChild;
                while (el && !found) {
                    if (el.nodeType == 8) { // 8==comment
                        var templateBody = el.nodeValue; // this is inside the comment
                        found=true;
                        break;
                    }
                    el=el.nextSibling;
                }
                if (!found)
                    var templateBody = tmpl.html(); // this is the whole template

                if (!templateBody.match(/##\w+##/)) { // is Resig' style? e.g. (#=id#) or (# ...some javascript code 'obj' is the alias for the object #)
                    var strFunc =
                        "var p=[],print=function(){p.push.apply(p,arguments);};" +
                        "with(obj){p.push('" +
                        templateBody.replace(/[\r\t\n]/g, " ")
                            .replace(/'(?=[^#]*#\))/g, "\t")
                            .split("'").join("\\'")
                            .split("\t").join("'")
                            .replace(/\(#=(.+?)#\)/g, "',$1,'")
                            .split("(#").join("');")
                            .split("#)").join("p.push('")
                        + "');}return p.join('');";

                    try {
                        $.JST._templates[type] = new Function("obj", strFunc);
                    } catch (e) {
                        console.error("JST error: "+type, e,strFunc);
                    }

                } else { //plain template   e.g. ##id##
                    try {
                        $.JST._templates[type] = templateBody;
                    } catch (e) {
                        console.error("JST error: "+type, e,templateBody);
                    }
                }

                tmpl.remove();

            });
        });
    },

    createFromTemplate: function(jsonData, template, transformToPrintable) {
        var templates = $.JST._templates;

        var jsData=new Object();
        if (transformToPrintable){
            for (var prop in jsonData){
                var value = jsonData[prop];
                if (typeof(value) == "string")
                    value = (value + "").replace(/\n/g, "<br>");
                jsData[prop]=value;
            }
        } else {
            jsData=jsonData;
        }

        function fillStripData(strip, data) {
            for (var prop in data) {
                var value = data[prop];

                strip = strip.replace(new RegExp("##" + prop + "##", "gi"), value);
            }
            // then clean the remaining ##xxx##
            strip = strip.replace(new RegExp("##\\w+##", "gi"), "");
            return strip;
        }

        var stripString = "";
        if (typeof(template) == "undefined") {
            alert("Template is required");
            stripString = "<div>Template is required</div>";

        } else if (typeof(templates[template]) == "function") { // resig template
            try {
                stripString = templates[template](jsData);// create a jquery object in memory
            } catch (e) {
                console.error("JST error: "+template,e.message);
                stripString = "<div> ERROR: "+template+"<br>" + e.message + "</div>";
            }

        } else {
            stripString = templates[template]; // recover strip template
            if (!stripString || stripString.trim() == "") {
                console.error("No template found for type '" + template + "'");
                return $("<div>");

            } else {
                stripString = fillStripData(stripString, jsData); //replace placeholders with data
            }
        }

        var ret = $(stripString);// create a jquery object in memory
        ret.attr("__template", template); // set __template attribute

        //decorate the strip
        var dec = $.JST._decorators[template];
        if (typeof (dec) == "function")
            dec(ret, jsData);

        return ret;
    },


    existsTemplate: function(template) {
        return $.JST._templates[template];
    },

    //decorate function is like function(domElement,jsonData){...}
    loadDecorator:function(template, decorator) {
        $.JST._decorators[template] = decorator;
    },

    getDecorator:function(template) {
        return $.JST._decorators[template];
    },

    decorateTemplate:function(element) {
        var dec = $.JST._decorators[element.attr("__template")];
        if (typeof (dec) == "function")
            dec(editor);
    },

    // asynchronous
    ajaxLoadAsynchTemplates: function(templateUrl, callback) {

        $.get(templateUrl, function(data) {

            var div = $("<div>");
            div.html(data);

            $.JST.loadTemplates(div);

            if (typeof(callback == "function"))
                callback();
        },"html");
    },

    ajaxLoadTemplates: function(templateUrl) {
        $.ajax({
            async:false,
            url: templateUrl,
            dataType: "html",
            success: function(data) {
                var div = $("<div>");
                div.html(data);
                $.JST.loadTemplates(div);
            }
        });

    }


};




/* http://keith-wood.name/svg.html
 SVG for jQuery v1.4.5.
 Written by Keith Wood (kbwood{at}iinet.com.au) August 2007.
 Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and
 MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses.
 Please attribute the author if you use it. */
(function($){function SVGManager(){this._settings=[];this._extensions=[];this.regional=[];this.regional['']={errorLoadingText:'Error loading',notSupportedText:'This browser does not support SVG'};this.local=this.regional[''];this._uuid=new Date().getTime();this._renesis=detectActiveX('RenesisX.RenesisCtrl')}function detectActiveX(a){try{return!!(window.ActiveXObject&&new ActiveXObject(a))}catch(e){return false}}var q='svgwrapper';$.extend(SVGManager.prototype,{markerClassName:'hasSVG',svgNS:'http://www.w3.org/2000/svg',xlinkNS:'http://www.w3.org/1999/xlink',_wrapperClass:SVGWrapper,_attrNames:{class_:'class',in_:'in',alignmentBaseline:'alignment-baseline',baselineShift:'baseline-shift',clipPath:'clip-path',clipRule:'clip-rule',colorInterpolation:'color-interpolation',colorInterpolationFilters:'color-interpolation-filters',colorRendering:'color-rendering',dominantBaseline:'dominant-baseline',enableBackground:'enable-background',fillOpacity:'fill-opacity',fillRule:'fill-rule',floodColor:'flood-color',floodOpacity:'flood-opacity',fontFamily:'font-family',fontSize:'font-size',fontSizeAdjust:'font-size-adjust',fontStretch:'font-stretch',fontStyle:'font-style',fontVariant:'font-variant',fontWeight:'font-weight',glyphOrientationHorizontal:'glyph-orientation-horizontal',glyphOrientationVertical:'glyph-orientation-vertical',horizAdvX:'horiz-adv-x',horizOriginX:'horiz-origin-x',imageRendering:'image-rendering',letterSpacing:'letter-spacing',lightingColor:'lighting-color',markerEnd:'marker-end',markerMid:'marker-mid',markerStart:'marker-start',stopColor:'stop-color',stopOpacity:'stop-opacity',strikethroughPosition:'strikethrough-position',strikethroughThickness:'strikethrough-thickness',strokeDashArray:'stroke-dasharray',strokeDashOffset:'stroke-dashoffset',strokeLineCap:'stroke-linecap',strokeLineJoin:'stroke-linejoin',strokeMiterLimit:'stroke-miterlimit',strokeOpacity:'stroke-opacity',strokeWidth:'stroke-width',textAnchor:'text-anchor',textDecoration:'text-decoration',textRendering:'text-rendering',underlinePosition:'underline-position',underlineThickness:'underline-thickness',vertAdvY:'vert-adv-y',vertOriginY:'vert-origin-y',wordSpacing:'word-spacing',writingMode:'writing-mode'},_attachSVG:function(a,b){var c=(a.namespaceURI==this.svgNS?a:null);var a=(c?null:a);if($(a||c).hasClass(this.markerClassName)){return}if(typeof b=='string'){b={loadURL:b}}else if(typeof b=='function'){b={onLoad:b}}$(a||c).addClass(this.markerClassName);try{if(!c){c=document.createElementNS(this.svgNS,'svg');c.setAttribute('version','1.1');if(a.clientWidth>0){c.setAttribute('width',a.clientWidth)}if(a.clientHeight>0){c.setAttribute('height',a.clientHeight)}a.appendChild(c)}this._afterLoad(a,c,b||{})}catch(e){if($.browser.msie){if(!a.id){a.id='svg'+(this._uuid++)}this._settings[a.id]=b;a.innerHTML='<embed type="image/svg+xml" width="100%" '+'height="100%" src="'+(b.initPath||'')+'blank.svg" '+'pluginspage="http://www.adobe.com/svg/viewer/install/main.html"/>'}else{a.innerHTML='<p class="svg_error">'+this.local.notSupportedText+'</p>'}}},_registerSVG:function(){for(var i=0;i<document.embeds.length;i++){var a=document.embeds[i].parentNode;if(!$(a).hasClass($.svg.markerClassName)||$.data(a,q)){continue}var b=null;try{b=document.embeds[i].getSVGDocument()}catch(e){setTimeout($.svg._registerSVG,250);return}b=(b?b.documentElement:null);if(b){$.svg._afterLoad(a,b)}}},_afterLoad:function(a,b,c){var c=c||this._settings[a.id];this._settings[a?a.id:'']=null;var d=new this._wrapperClass(b,a);$.data(a||b,q,d);try{if(c.loadURL){d.load(c.loadURL,c)}if(c.settings){d.configure(c.settings)}if(c.onLoad&&!c.loadURL){c.onLoad.apply(a||b,[d])}}catch(e){alert(e)}},_getSVG:function(a){a=(typeof a=='string'?$(a)[0]:(a.jquery?a[0]:a));return $.data(a,q)},_destroySVG:function(a){var b=$(a);if(!b.hasClass(this.markerClassName)){return}b.removeClass(this.markerClassName);if(a.namespaceURI!=this.svgNS){b.empty()}$.removeData(a,q)},addExtension:function(a,b){this._extensions.push([a,b])},isSVGElem:function(a){return(a.nodeType==1&&a.namespaceURI==$.svg.svgNS)}});function SVGWrapper(a,b){this._svg=a;this._container=b;for(var i=0;i<$.svg._extensions.length;i++){var c=$.svg._extensions[i];this[c[0]]=new c[1](this)}}$.extend(SVGWrapper.prototype,{_width:function(){return(this._container?this._container.clientWidth:this._svg.width)},_height:function(){return(this._container?this._container.clientHeight:this._svg.height)},root:function(){return this._svg},configure:function(a,b,c){if(!a.nodeName){c=b;b=a;a=this._svg}if(c){for(var i=a.attributes.length-1;i>=0;i--){var d=a.attributes.item(i);if(!(d.nodeName=='onload'||d.nodeName=='version'||d.nodeName.substring(0,5)=='xmlns')){a.attributes.removeNamedItem(d.nodeName)}}}for(var e in b){a.setAttribute($.svg._attrNames[e]||e,b[e])}return this},getElementById:function(a){return this._svg.ownerDocument.getElementById(a)},change:function(a,b){if(a){for(var c in b){if(b[c]==null){a.removeAttribute($.svg._attrNames[c]||c)}else{a.setAttribute($.svg._attrNames[c]||c,b[c])}}}return this},_args:function(b,c,d){c.splice(0,0,'parent');c.splice(c.length,0,'settings');var e={};var f=0;if(b[0]!=null&&b[0].jquery){b[0]=b[0][0]}if(b[0]!=null&&!(typeof b[0]=='object'&&b[0].nodeName)){e['parent']=null;f=1}for(var i=0;i<b.length;i++){e[c[i+f]]=b[i]}if(d){$.each(d,function(i,a){if(typeof e[a]=='object'){e.settings=e[a];e[a]=null}})}return e},title:function(a,b,c){var d=this._args(arguments,['text']);var e=this._makeNode(d.parent,'title',d.settings||{});e.appendChild(this._svg.ownerDocument.createTextNode(d.text));return e},describe:function(a,b,c){var d=this._args(arguments,['text']);var e=this._makeNode(d.parent,'desc',d.settings||{});e.appendChild(this._svg.ownerDocument.createTextNode(d.text));return e},defs:function(a,b,c){var d=this._args(arguments,['id'],['id']);return this._makeNode(d.parent,'defs',$.extend((d.id?{id:d.id}:{}),d.settings||{}))},symbol:function(a,b,c,d,e,f,g){var h=this._args(arguments,['id','x1','y1','width','height']);return this._makeNode(h.parent,'symbol',$.extend({id:h.id,viewBox:h.x1+' '+h.y1+' '+h.width+' '+h.height},h.settings||{}))},marker:function(a,b,c,d,e,f,g,h){var i=this._args(arguments,['id','refX','refY','mWidth','mHeight','orient'],['orient']);return this._makeNode(i.parent,'marker',$.extend({id:i.id,refX:i.refX,refY:i.refY,markerWidth:i.mWidth,markerHeight:i.mHeight,orient:i.orient||'auto'},i.settings||{}))},style:function(a,b,c){var d=this._args(arguments,['styles']);var e=this._makeNode(d.parent,'style',$.extend({type:'text/css'},d.settings||{}));e.appendChild(this._svg.ownerDocument.createTextNode(d.styles));if($.browser.opera){$('head').append('<style type="text/css">'+d.styles+'</style>')}return e},script:function(a,b,c,d){var e=this._args(arguments,['script','type'],['type']);var f=this._makeNode(e.parent,'script',$.extend({type:e.type||'text/javascript'},e.settings||{}));f.appendChild(this._svg.ownerDocument.createTextNode(e.script));if(!$.browser.mozilla){$.globalEval(e.script)}return f},linearGradient:function(a,b,c,d,e,f,g,h){var i=this._args(arguments,['id','stops','x1','y1','x2','y2'],['x1']);var j=$.extend({id:i.id},(i.x1!=null?{x1:i.x1,y1:i.y1,x2:i.x2,y2:i.y2}:{}));return this._gradient(i.parent,'linearGradient',$.extend(j,i.settings||{}),i.stops)},radialGradient:function(a,b,c,d,e,r,f,g,h){var i=this._args(arguments,['id','stops','cx','cy','r','fx','fy'],['cx']);var j=$.extend({id:i.id},(i.cx!=null?{cx:i.cx,cy:i.cy,r:i.r,fx:i.fx,fy:i.fy}:{}));return this._gradient(i.parent,'radialGradient',$.extend(j,i.settings||{}),i.stops)},_gradient:function(a,b,c,d){var e=this._makeNode(a,b,c);for(var i=0;i<d.length;i++){var f=d[i];this._makeNode(e,'stop',$.extend({offset:f[0],stopColor:f[1]},(f[2]!=null?{stopOpacity:f[2]}:{})))}return e},pattern:function(a,b,x,y,c,d,e,f,g,h,i){var j=this._args(arguments,['id','x','y','width','height','vx','vy','vwidth','vheight'],['vx']);var k=$.extend({id:j.id,x:j.x,y:j.y,width:j.width,height:j.height},(j.vx!=null?{viewBox:j.vx+' '+j.vy+' '+j.vwidth+' '+j.vheight}:{}));return this._makeNode(j.parent,'pattern',$.extend(k,j.settings||{}))},clipPath:function(a,b,c,d){var e=this._args(arguments,['id','units']);e.units=e.units||'userSpaceOnUse';return this._makeNode(e.parent,'clipPath',$.extend({id:e.id,clipPathUnits:e.units},e.settings||{}))},mask:function(a,b,x,y,c,d,e){var f=this._args(arguments,['id','x','y','width','height']);return this._makeNode(f.parent,'mask',$.extend({id:f.id,x:f.x,y:f.y,width:f.width,height:f.height},f.settings||{}))},createPath:function(){return new SVGPath()},createText:function(){return new SVGText()},svg:function(a,x,y,b,c,d,e,f,g,h){var i=this._args(arguments,['x','y','width','height','vx','vy','vwidth','vheight'],['vx']);var j=$.extend({x:i.x,y:i.y,width:i.width,height:i.height},(i.vx!=null?{viewBox:i.vx+' '+i.vy+' '+i.vwidth+' '+i.vheight}:{}));return this._makeNode(i.parent,'svg',$.extend(j,i.settings||{}))},group:function(a,b,c){var d=this._args(arguments,['id'],['id']);return this._makeNode(d.parent,'g',$.extend({id:d.id},d.settings||{}))},use:function(a,x,y,b,c,d,e){var f=this._args(arguments,['x','y','width','height','ref']);if(typeof f.x=='string'){f.ref=f.x;f.settings=f.y;f.x=f.y=f.width=f.height=null}var g=this._makeNode(f.parent,'use',$.extend({x:f.x,y:f.y,width:f.width,height:f.height},f.settings||{}));g.setAttributeNS($.svg.xlinkNS,'href',f.ref);return g},link:function(a,b,c){var d=this._args(arguments,['ref']);var e=this._makeNode(d.parent,'a',d.settings);e.setAttributeNS($.svg.xlinkNS,'href',d.ref);return e},image:function(a,x,y,b,c,d,e){var f=this._args(arguments,['x','y','width','height','ref']);var g=this._makeNode(f.parent,'image',$.extend({x:f.x,y:f.y,width:f.width,height:f.height},f.settings||{}));g.setAttributeNS($.svg.xlinkNS,'href',f.ref);return g},path:function(a,b,c){var d=this._args(arguments,['path']);return this._makeNode(d.parent,'path',$.extend({d:(d.path.path?d.path.path():d.path)},d.settings||{}))},rect:function(a,x,y,b,c,d,e,f){var g=this._args(arguments,['x','y','width','height','rx','ry'],['rx']);return this._makeNode(g.parent,'rect',$.extend({x:g.x,y:g.y,width:g.width,height:g.height},(g.rx?{rx:g.rx,ry:g.ry}:{}),g.settings||{}))},circle:function(a,b,c,r,d){var e=this._args(arguments,['cx','cy','r']);return this._makeNode(e.parent,'circle',$.extend({cx:e.cx,cy:e.cy,r:e.r},e.settings||{}))},ellipse:function(a,b,c,d,e,f){var g=this._args(arguments,['cx','cy','rx','ry']);return this._makeNode(g.parent,'ellipse',$.extend({cx:g.cx,cy:g.cy,rx:g.rx,ry:g.ry},g.settings||{}))},line:function(a,b,c,d,e,f){var g=this._args(arguments,['x1','y1','x2','y2']);return this._makeNode(g.parent,'line',$.extend({x1:g.x1,y1:g.y1,x2:g.x2,y2:g.y2},g.settings||{}))},polyline:function(a,b,c){var d=this._args(arguments,['points']);return this._poly(d.parent,'polyline',d.points,d.settings)},polygon:function(a,b,c){var d=this._args(arguments,['points']);return this._poly(d.parent,'polygon',d.points,d.settings)},_poly:function(a,b,c,d){var e='';for(var i=0;i<c.length;i++){e+=c[i].join()+' '}return this._makeNode(a,b,$.extend({points:$.trim(e)},d||{}))},text:function(a,x,y,b,c){var d=this._args(arguments,['x','y','value']);if(typeof d.x=='string'&&arguments.length<4){d.value=d.x;d.settings=d.y;d.x=d.y=null}return this._text(d.parent,'text',d.value,$.extend({x:(d.x&&isArray(d.x)?d.x.join(' '):d.x),y:(d.y&&isArray(d.y)?d.y.join(' '):d.y)},d.settings||{}))},textpath:function(a,b,c,d){var e=this._args(arguments,['path','value']);var f=this._text(e.parent,'textPath',e.value,e.settings||{});f.setAttributeNS($.svg.xlinkNS,'href',e.path);return f},_text:function(a,b,c,d){var e=this._makeNode(a,b,d);if(typeof c=='string'){e.appendChild(e.ownerDocument.createTextNode(c))}else{for(var i=0;i<c._parts.length;i++){var f=c._parts[i];if(f[0]=='tspan'){var g=this._makeNode(e,f[0],f[2]);g.appendChild(e.ownerDocument.createTextNode(f[1]));e.appendChild(g)}else if(f[0]=='tref'){var g=this._makeNode(e,f[0],f[2]);g.setAttributeNS($.svg.xlinkNS,'href',f[1]);e.appendChild(g)}else if(f[0]=='textpath'){var h=$.extend({},f[2]);h.href=null;var g=this._makeNode(e,f[0],h);g.setAttributeNS($.svg.xlinkNS,'href',f[2].href);g.appendChild(e.ownerDocument.createTextNode(f[1]));e.appendChild(g)}else{e.appendChild(e.ownerDocument.createTextNode(f[1]))}}}return e},other:function(a,b,c){var d=this._args(arguments,['name']);return this._makeNode(d.parent,d.name,d.settings||{})},_makeNode:function(a,b,c){a=a||this._svg;var d=this._svg.ownerDocument.createElementNS($.svg.svgNS,b);for(var b in c){var e=c[b];if(e!=null&&e!=null&&(typeof e!='string'||e!='')){d.setAttribute($.svg._attrNames[b]||b,e)}}a.appendChild(d);return d},add:function(b,c){var d=this._args((arguments.length==1?[null,b]:arguments),['node']);var f=this;d.parent=d.parent||this._svg;d.node=(d.node.jquery?d.node:$(d.node));try{if($.svg._renesis){throw'Force traversal';}d.parent.appendChild(d.node.cloneNode(true))}catch(e){d.node.each(function(){var a=f._cloneAsSVG(this);if(a){d.parent.appendChild(a)}})}return this},clone:function(b,c){var d=this;var e=this._args((arguments.length==1?[null,b]:arguments),['node']);e.parent=e.parent||this._svg;e.node=(e.node.jquery?e.node:$(e.node));var f=[];e.node.each(function(){var a=d._cloneAsSVG(this);if(a){a.id='';e.parent.appendChild(a);f.push(a)}});return f},_cloneAsSVG:function(a){var b=null;if(a.nodeType==1){b=this._svg.ownerDocument.createElementNS($.svg.svgNS,this._checkName(a.nodeName));for(var i=0;i<a.attributes.length;i++){var c=a.attributes.item(i);if(c.nodeName!='xmlns'&&c.nodeValue){if(c.prefix=='xlink'){b.setAttributeNS($.svg.xlinkNS,c.localName||c.baseName,c.nodeValue)}else{b.setAttribute(this._checkName(c.nodeName),c.nodeValue)}}}for(var i=0;i<a.childNodes.length;i++){var d=this._cloneAsSVG(a.childNodes[i]);if(d){b.appendChild(d)}}}else if(a.nodeType==3){if($.trim(a.nodeValue)){b=this._svg.ownerDocument.createTextNode(a.nodeValue)}}else if(a.nodeType==4){if($.trim(a.nodeValue)){try{b=this._svg.ownerDocument.createCDATASection(a.nodeValue)}catch(e){b=this._svg.ownerDocument.createTextNode(a.nodeValue.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'))}}}return b},_checkName:function(a){a=(a.substring(0,1)>='A'&&a.substring(0,1)<='Z'?a.toLowerCase():a);return(a.substring(0,4)=='svg:'?a.substring(4):a)},load:function(j,k){k=(typeof k=='boolean'?{addTo:k}:(typeof k=='function'?{onLoad:k}:(typeof k=='string'?{parent:k}:(typeof k=='object'&&k.nodeName?{parent:k}:(typeof k=='object'&&k.jquery?{parent:k}:k||{})))));if(!k.parent&&!k.addTo){this.clear(false)}var l=[this._svg.getAttribute('width'),this._svg.getAttribute('height')];var m=this;var n=function(a){a=$.svg.local.errorLoadingText+': '+a;if(k.onLoad){k.onLoad.apply(m._container||m._svg,[m,a])}else{m.text(null,10,20,a)}};var o=function(a){var b=new ActiveXObject('Microsoft.XMLDOM');b.validateOnParse=false;b.resolveExternals=false;b.async=false;b.loadXML(a);if(b.parseError.errorCode!=0){n(b.parseError.reason);return null}return b};var p=function(a){if(!a){return}if(a.documentElement.nodeName!='svg'){var b=a.getElementsByTagName('parsererror');var c=(b.length?b[0].getElementsByTagName('div'):[]);n(!b.length?'???':(c.length?c[0]:b[0]).firstChild.nodeValue);return}var d=(k.parent?$(k.parent)[0]:m._svg);var f={};for(var i=0;i<a.documentElement.attributes.length;i++){var g=a.documentElement.attributes.item(i);if(!(g.nodeName=='version'||g.nodeName.substring(0,5)=='xmlns')){f[g.nodeName]=g.nodeValue}}m.configure(d,f,!k.parent);var h=a.documentElement.childNodes;for(var i=0;i<h.length;i++){try{if($.svg._renesis){throw'Force traversal';}d.appendChild(m._svg.ownerDocument.importNode(h[i],true));if(h[i].nodeName=='script'){$.globalEval(h[i].textContent)}}catch(e){m.add(d,h[i])}}if(!k.changeSize){m.configure(d,{width:l[0],height:l[1]})}if(k.onLoad){k.onLoad.apply(m._container||m._svg,[m])}};if(j.match('<svg')){p($.browser.msie?o(j):new DOMParser().parseFromString(j,'text/xml'))}else{$.ajax({url:j,dataType:($.browser.msie?'text':'xml'),success:function(a){p($.browser.msie?o(a):a)},error:function(a,b,c){n(b+(c?' '+c.message:''))}})}return this},remove:function(a){a=(a.jquery?a[0]:a);a.parentNode.removeChild(a);return this},clear:function(a){if(a){this.configure({},true)}while(this._svg.firstChild){this._svg.removeChild(this._svg.firstChild)}return this},toSVG:function(a){a=a||this._svg;return(typeof XMLSerializer=='undefined'?this._toSVG(a):new XMLSerializer().serializeToString(a))},_toSVG:function(a){var b='';if(!a){return b}if(a.nodeType==3){b=a.nodeValue}else if(a.nodeType==4){b='<![CDATA['+a.nodeValue+']]>'}else{b='<'+a.nodeName;if(a.attributes){for(var i=0;i<a.attributes.length;i++){var c=a.attributes.item(i);if(!($.trim(c.nodeValue)==''||c.nodeValue.match(/^\[object/)||c.nodeValue.match(/^function/))){b+=' '+(c.namespaceURI==$.svg.xlinkNS?'xlink:':'')+c.nodeName+'="'+c.nodeValue+'"'}}}if(a.firstChild){b+='>';var d=a.firstChild;while(d){b+=this._toSVG(d);d=d.nextSibling}b+='</'+a.nodeName+'>'}else{b+='/>'}}return b}});function SVGPath(){this._path=''}$.extend(SVGPath.prototype,{reset:function(){this._path='';return this},move:function(x,y,a){a=(isArray(x)?y:a);return this._coords((a?'m':'M'),x,y)},line:function(x,y,a){a=(isArray(x)?y:a);return this._coords((a?'l':'L'),x,y)},horiz:function(x,a){this._path+=(a?'h':'H')+(isArray(x)?x.join(' '):x);return this},vert:function(y,a){this._path+=(a?'v':'V')+(isArray(y)?y.join(' '):y);return this},curveC:function(a,b,c,d,x,y,e){e=(isArray(a)?b:e);return this._coords((e?'c':'C'),a,b,c,d,x,y)},smoothC:function(a,b,x,y,c){c=(isArray(a)?b:c);return this._coords((c?'s':'S'),a,b,x,y)},curveQ:function(a,b,x,y,c){c=(isArray(a)?b:c);return this._coords((c?'q':'Q'),a,b,x,y)},smoothQ:function(x,y,a){a=(isArray(x)?y:a);return this._coords((a?'t':'T'),x,y)},_coords:function(a,b,c,d,e,f,g){if(isArray(b)){for(var i=0;i<b.length;i++){var h=b[i];this._path+=(i==0?a:' ')+h[0]+','+h[1]+(h.length<4?'':' '+h[2]+','+h[3]+(h.length<6?'':' '+h[4]+','+h[5]))}}else{this._path+=a+b+','+c+(d==null?'':' '+d+','+e+(f==null?'':' '+f+','+g))}return this},arc:function(a,b,c,d,e,x,y,f){f=(isArray(a)?b:f);this._path+=(f?'a':'A');if(isArray(a)){for(var i=0;i<a.length;i++){var g=a[i];this._path+=(i==0?'':' ')+g[0]+','+g[1]+' '+g[2]+' '+(g[3]?'1':'0')+','+(g[4]?'1':'0')+' '+g[5]+','+g[6]}}else{this._path+=a+','+b+' '+c+' '+(d?'1':'0')+','+(e?'1':'0')+' '+x+','+y}return this},close:function(){this._path+='z';return this},path:function(){return this._path}});SVGPath.prototype.moveTo=SVGPath.prototype.move;SVGPath.prototype.lineTo=SVGPath.prototype.line;SVGPath.prototype.horizTo=SVGPath.prototype.horiz;SVGPath.prototype.vertTo=SVGPath.prototype.vert;SVGPath.prototype.curveCTo=SVGPath.prototype.curveC;SVGPath.prototype.smoothCTo=SVGPath.prototype.smoothC;SVGPath.prototype.curveQTo=SVGPath.prototype.curveQ;SVGPath.prototype.smoothQTo=SVGPath.prototype.smoothQ;SVGPath.prototype.arcTo=SVGPath.prototype.arc;function SVGText(){this._parts=[]}$.extend(SVGText.prototype,{reset:function(){this._parts=[];return this},string:function(a){this._parts[this._parts.length]=['text',a];return this},span:function(a,b){this._parts[this._parts.length]=['tspan',a,b];return this},ref:function(a,b){this._parts[this._parts.length]=['tref',a,b];return this},path:function(a,b,c){this._parts[this._parts.length]=['textpath',b,$.extend({href:a},c||{})];return this}});$.fn.svg=function(a){var b=Array.prototype.slice.call(arguments,1);if(typeof a=='string'&&a=='get'){return $.svg['_'+a+'SVG'].apply($.svg,[this[0]].concat(b))}return this.each(function(){if(typeof a=='string'){$.svg['_'+a+'SVG'].apply($.svg,[this].concat(b))}else{$.svg._attachSVG(this,a||{})}})};function isArray(a){return(a&&a.constructor==Array)}$.svg=new SVGManager()})(jQuery);





/* http://keith-wood.name/svg.html
 jQuery DOM compatibility for jQuery SVG v1.4.5.
 Written by Keith Wood (kbwood{at}iinet.com.au) April 2009.
 Dual licensed under the GPL (http://dev.jquery.com/browser/trunk/jquery/GPL-LICENSE.txt) and
 MIT (http://dev.jquery.com/browser/trunk/jquery/MIT-LICENSE.txt) licenses.
 Please attribute the author if you use it. */

(function ($) { // Hide scope, no $ conflict

    var rclass = /[\t\r\n]/g,
        rspace = /\s+/,
        rwhitespace = "[\\x20\\t\\r\\n\\f]";

    /* Support adding class names to SVG nodes. */
    $.fn.addClass = function (origAddClass) {
        return function (value) {
            var classNames, i, l, elem,
                setClass, c, cl;

            if (jQuery.isFunction(value)) {
                return this.each(function (j) {
                    jQuery(this).addClass(value.call(this, j, this.className));
                });
            }

            if (value && typeof value === "string") {
                classNames = value.split(rspace);

                for (i = 0, l = this.length; i < l; i++) {
                    elem = this[ i ];

                    if (elem.nodeType === 1) {
                        if (!(elem.className && elem.getAttribute('class')) && classNames.length === 1) {
                            if ($.svg.isSVGElem(elem)) {
                                (elem.className ? elem.className.baseVal = value
                                    : elem.setAttribute('class', value));
                            } else {
                                elem.className = value;
                            }
                        } else {
                            setClass = !$.svg.isSVGElem(elem) ? elem.className :
                                elem.className ? elem.className.baseVal :
                                    elem.getAttribute('class');

                            setClass = (" " + setClass + " ");
                            for (c = 0, cl = classNames.length; c < cl; c++) {
                                if (setClass.indexOf(" " + classNames[ c ] + " ") < 0) {
                                    setClass += classNames[ c ] + " ";
                                }
                            }

                            setClass = jQuery.trim(setClass);
                            if ($.svg.isSVGElem(elem)) {

                                (elem.className ? elem.className.baseVal = setClass
                                    : elem.setAttribute('class', setClass));
                            } else {
                                elem.className = setClass;
                            }
                        }
                    }
                }
            }

            return this;
        };
    }($.fn.addClass);

    /* Support removing class names from SVG nodes. */
    $.fn.removeClass = function (origRemoveClass) {
        return function (value) {
            var classNames, i, l, elem, className, c, cl;

            if (jQuery.isFunction(value)) {
                return this.each(function (j) {
                    jQuery(this).removeClass(value.call(this, j, this.className));
                });
            }

            if ((value && typeof value === "string") || value === undefined) {
                classNames = ( value || "" ).split(rspace);

                for (i = 0, l = this.length; i < l; i++) {
                    elem = this[ i ];

                    if (elem.nodeType === 1 && (elem.className || elem.getAttribute('class'))) {
                        if (value) {
                            className = !$.svg.isSVGElem(elem) ? elem.className :
                                elem.className ? elem.className.baseVal :
                                    elem.getAttribute('class');

                            className = (" " + className + " ").replace(rclass, " ");

                            for (c = 0, cl = classNames.length; c < cl; c++) {
                                // Remove until there is nothing to remove,
                                while (className.indexOf(" " + classNames[ c ] + " ") >= 0) {
                                    className = className.replace(" " + classNames[ c ] + " ", " ");
                                }
                            }

                            className = jQuery.trim(className);
                        } else {
                            className = "";
                        }

                        if ($.svg.isSVGElem(elem)) {
                            (elem.className ? elem.className.baseVal = className
                                : elem.setAttribute('class', className));
                        } else {
                            elem.className = className;
                        }
                    }
                }
            }

            return this;
        };
    }($.fn.removeClass);

    /* Support toggling class names on SVG nodes. */
    $.fn.toggleClass = function (origToggleClass) {
        return function (className, state) {
            return this.each(function () {
                if ($.svg.isSVGElem(this)) {
                    if (typeof state !== 'boolean') {
                        state = !$(this).hasClass(className);
                    }
                    $(this)[(state ? 'add' : 'remove') + 'Class'](className);
                }
                else {
                    origToggleClass.apply($(this), [className, state]);
                }
            });
        };
    }($.fn.toggleClass);

    /* Support checking class names on SVG nodes. */
    $.fn.hasClass = function (origHasClass) {
        return function (selector) {

            var className = " " + selector + " ",
                i = 0,
                l = this.length,
                elem, classes;

            for (; i < l; i++) {
                elem = this[i];
                if (elem.nodeType === 1) {
                    classes = !$.svg.isSVGElem(elem) ? elem.className :
                        elem.className ? elem.className.baseVal :
                            elem.getAttribute('class');
                    if ((" " + classes + " ").replace(rclass, " ").indexOf(className) > -1) {
                        return true;
                    }
                }
            }

            return false;
        };
    }($.fn.hasClass);

    /* Support attributes on SVG nodes. */
    $.fn.attr = function (origAttr) {
        return function (name, value, type) {
            var origArgs = arguments;
            if (typeof name === 'string' && value === undefined) {
                var val = origAttr.apply(this, origArgs);
                if (val && val.baseVal && val.baseVal.numberOfItems != null) { // Multiple values
                    value = '';
                    val = val.baseVal;
                    if (name == 'transform') {
                        for (var i = 0; i < val.numberOfItems; i++) {
                            var item = val.getItem(i);
                            switch (item.type) {
                                case 1:
                                    value += ' matrix(' + item.matrix.a + ',' + item.matrix.b + ',' +
                                        item.matrix.c + ',' + item.matrix.d + ',' +
                                        item.matrix.e + ',' + item.matrix.f + ')';
                                    break;
                                case 2:
                                    value += ' translate(' + item.matrix.e + ',' + item.matrix.f + ')';
                                    break;
                                case 3:
                                    value += ' scale(' + item.matrix.a + ',' + item.matrix.d + ')';
                                    break;
                                case 4:
                                    value += ' rotate(' + item.angle + ')';
                                    break; // Doesn't handle new origin
                                case 5:
                                    value += ' skewX(' + item.angle + ')';
                                    break;
                                case 6:
                                    value += ' skewY(' + item.angle + ')';
                                    break;
                            }
                        }
                        val = value.substring(1);
                    }
                    else {
                        val = val.getItem(0).valueAsString;
                    }
                }
                return (val && val.baseVal ? val.baseVal.valueAsString : val);
            }

            var options = name;
            if (typeof name === 'string') {
                options = {};
                options[name] = value;
            }
            return $(this).each(function () {
                if ($.svg.isSVGElem(this)) {
                    for (var n in options) {
                        var val = ($.isFunction(options[n]) ? options[n]() : options[n]);
                        (type ? this.style[n] = val : this.setAttribute(n, val));
                    }
                }
                else {
                    origAttr.apply($(this), origArgs);
                }
            });
        };
    }($.fn.attr);

    /* Support removing attributes on SVG nodes. */
    $.fn.removeAttr = function (origRemoveAttr) {
        return function (name) {
            return this.each(function () {
                if ($.svg.isSVGElem(this)) {
                    (this[name] && this[name].baseVal ? this[name].baseVal.value = '' :
                        this.setAttribute(name, ''));
                }
                else {
                    origRemoveAttr.apply($(this), [name]);
                }
            });
        };
    }($.fn.removeAttr);

    /* Add numeric only properties. */
    $.extend($.cssNumber, {
        'stopOpacity':     true,
        'strokeMitrelimit':true,
        'strokeOpacity':   true
    });

    /* Support retrieving CSS/attribute values on SVG nodes. */
    if ($.cssProps) {
        $.css = function (origCSS) {
            return function (elem, name, numeric, extra) {
                var value = (name.match(/^svg.*/) ? $(elem).attr($.cssProps[name] || name) : '');
                return value || origCSS(elem, name, numeric, extra);
            };
        }($.css);
    }

    $.find.isXML = function (origIsXml) {
        return function (elem) {
            return $.svg.isSVGElem(elem) || origIsXml(elem);
        }
    }($.find.isXML)

    var div = document.createElement('div');
    div.appendChild(document.createComment(''));
    if (div.getElementsByTagName('*').length > 0) { // Make sure no comments are found
        $.expr.find.TAG = function (match, context) {
            var results = context.getElementsByTagName(match[1]);
            if (match[1] === '*') { // Filter out possible comments
                var tmp = [];
                for (var i = 0; results[i] || results.item(i); i++) {
                    if ((results[i] || results.item(i)).nodeType === 1) {
                        tmp.push(results[i] || results.item(i));
                    }
                }
                results = tmp;
            }
            return results;
        };
    }

    $.expr.filter.CLASS = function (className) {
        var pattern = new RegExp("(^|" + rwhitespace + ")" + className + "(" + rwhitespace + "|$)");
        return function (elem) {
            var elemClass = (!$.svg.isSVGElem(elem) ? elem.className || (typeof elem.getAttribute !== "undefined" && elem.getAttribute("class")) || "" :
                (elem.className ? elem.className.baseVal : elem.getAttribute('class')));

            return pattern.test(elemClass);
        };
    };

    /*
     In the removeData function (line 1881, v1.7.2):

     if ( jQuery.support.deleteExpando ) {
     delete elem[ internalKey ];
     } else {
     try { // SVG
     elem.removeAttribute( internalKey );
     } catch (e) {
     elem[ internalKey ] = null;
     }
     }

     In the event.add function (line 2985, v1.7.2):

     if ( !special.setup || special.setup.call( elem, data, namespaces, eventHandle ) === false ) {
     // Bind the global event handler to the element
     try { // SVG
     elem.addEventListener( type, eventHandle, false );
     } catch(e) {
     if ( elem.attachEvent ) {
     elem.attachEvent( "on" + type, eventHandle );
     }
     }
     }

     In the event.remove function (line 3074, v1.7.2):

     if ( !special.teardown || special.teardown.call( elem, namespaces ) === false ) {
     try { // SVG
     elem.removeEventListener(type, elemData.handle, false);
     }
     catch (e) {
     if (elem.detachEvent) {
     elem.detachEvent("on" + type, elemData.handle);
     }
     }
     }

     In the event.fix function (line 3394, v1.7.2):

     if (event.target.namespaceURI == 'http://www.w3.org/2000/svg') { // SVG
     event.button = [1, 4, 2][event.button];
     }

     // Add which for click: 1 === left; 2 === middle; 3 === right
     // Note: button is not normalized, so don't use it
     if ( !event.which && button !== undefined ) {
     event.which = ( button & 1 ? 1 : ( button & 2 ? 3 : ( button & 4 ? 2 : 0 ) ) );
     }

     In the Sizzle function (line 4083, v1.7.2):

     if ( toString.call(checkSet) === "[object Array]" ) {
     if ( !prune ) {
     results.push.apply( results, checkSet );

     } else if ( context && context.nodeType === 1 ) {
     for ( i = 0; checkSet[i] != null; i++ ) {
     if ( checkSet[i] && (checkSet[i] === true || checkSet[i].nodeType === 1 && Sizzle.contains(context, checkSet[i])) ) {
     results.push( set[i] || set.item(i) ); // SVG
     }
     }

     } else {
     for ( i = 0; checkSet[i] != null; i++ ) {
     if ( checkSet[i] && checkSet[i].nodeType === 1 ) {
     results.push( set[i] || set.item(i) ); // SVG
     }
     }
     }
     } else {...

     In the fallback for the Sizzle makeArray function (line 4877, v1.7.2):

     if ( toString.call(array) === "[object Array]" ) {
     Array.prototype.push.apply( ret, array );

     } else {
     if ( typeof array.length === "number" ) {
     for ( var l = array.length; i &lt; l; i++ ) {
     ret.push( array[i] || array.item(i) ); // SVG
     }

     } else {
     for ( ; array[i]; i++ ) {
     ret.push( array[i] );
     }
     }
     }

     In the jQuery.cleandata function (line 6538, v1.7.2):

     if ( deleteExpando ) {
     delete elem[ jQuery.expando ];

     } else {
     try { // SVG
     elem.removeAttribute( jQuery.expando );
     } catch (e) {
     // Ignore
     }
     }

     In the fallback getComputedStyle function (line 6727, v1.7.2):

     defaultView = (elem.ownerDocument ? elem.ownerDocument.defaultView : elem.defaultView); // SVG
     if ( defaultView &&
     (computedStyle = defaultView.getComputedStyle( elem, null )) ) {

     ret = computedStyle.getPropertyValue( name );
     ...

     */

})(jQuery);




/*
 Copyright (c) 2012-2017 Open Lab
 Written by Roberto Bicchierai and Silvia Chelazzi http://roberto.open-lab.com
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

$.gridify = function (table, opt) {
    var options = {
        resizeZoneWidth: 10
    };

    $.extend(options, opt);

    var box = $("<div>").addClass("gdfWrapper");
    box.append(table);

    var head = table.clone();
    head.addClass("table ganttFixHead");
    //remove non head
    head.find("tbody").remove();
    box.append(head);

    box.append(table);

    var hTh = head.find(".gdfColHeader");
    var cTh = table.find(".gdfColHeader");
    for (var i = 0; i < hTh.length; i++) {
        hTh.eq(i).data("fTh", cTh.eq(i));
    }

    //--------- set table to 0 to prevent a strange 100%
    table.width(0);
    head.width(0);


    //----------------------  header management start
    head.find("th.gdfColHeader:not(.gdfied)").mouseover(function () {
        $(this).addClass("gdfColHeaderOver");

    }).on("mouseout.gdf", function () {
        $(this).removeClass("gdfColHeaderOver");
        if (!$.gridify.columInResize) {
            $("body").removeClass("gdfHResizing");
        }

    }).on("mousemove.gdf", function (e) {
        if (!$.gridify.columInResize) {
            var colHeader = $(this);
            var nextCol = colHeader.next();
            if (nextCol.length > 0 && nextCol.width() < options.resizeZoneWidth)
                colHeader = nextCol;

            if (!colHeader.is(".gdfResizable"))
                return;

            var mousePos = e.pageX - colHeader.offset().left;

            if (colHeader.width() - mousePos < options.resizeZoneWidth) {
                $("body").addClass("gdfHResizing");
            } else {
                $("body").removeClass("gdfHResizing");
            }
        }

    }).on("mousedown.gdf", function (e) {
        //console.debug("mousedown.gdf")
        var colHeader = $(this);

        var nextCol = colHeader.next();
        if (nextCol.length > 0 && nextCol.width() < options.resizeZoneWidth)
            colHeader = nextCol;

        if (!colHeader.is(".gdfResizable"))
            return;

        var mousePos = e.pageX - colHeader.offset().left;
        if (colHeader.width() - mousePos < options.resizeZoneWidth) {
            $("body").unselectable();
            $.gridify.columInResize = colHeader;
            //on event for start resizing
            //console.debug("start resizing");
            $(document).on("mousemove.gdf", function (e) {

                e.preventDefault();
                $("body").addClass("gdfHResizing");

                //manage resizing
                var w = e.pageX - $.gridify.columInResize.offset().left;
                w = w <= 1 ? 1 : w;
                $.gridify.columInResize.width(w);
                $.gridify.columInResize.data("fTh").width(w);


                //on mouse up on body to stop resizing
            }).on("mouseup.gdf", function () {
                //console.debug("mouseup.gdf")

                //$("body").css({cursor: "auto"});

                $(this).off("mousemove.gdf").off("mouseup.gdf").clearUnselectable();
                $("body").removeClass("gdfHResizing");
                delete $.gridify.columInResize;

                //save columns dimension
                storeGridState();

            });
        }

    }).on("dblclick.gdf", function () {
        //console.debug("dblclick.gdf")
        var col = $(this);

        if (!col.is(".gdfResizable"))
            return;

        var idx = $("th", col.parents("table")).index(col);
        var columnTd = $("td:nth-child(" + (idx + 1) + ")", table);
        var w = 0;
        columnTd.each(function () {
            var td = $(this);
            var content = td.children("input").length ? td.children("input").val() : td.html();
            var tmp = $("<div/>").addClass("columnWidthTest").html(content).css({position: "absolute"});
            $("body").append(tmp);
            w = Math.max(w, tmp.width() + parseFloat(td.css("padding-left")));
            tmp.remove();
        });

        w = w + 5;
        col.width(w);
        col.data("fTh").width(w);

        //save columns dimension
        storeGridState();
        return false;

    }).addClass("gdfied unselectable").attr("unselectable", "true");


    function storeGridState() {
        //console.debug("storeGridState");
        if (localStorage) {
            var gridState = {};

            var colSizes = [];
            $(".gdfTable .gdfColHeader").each(function () {
                colSizes.push($(this).outerWidth());
            });

            gridState.colSizes = colSizes;

            localStorage.setObject("TWPGanttGridState", gridState);
            //console.debug("gridState",localStorage.getItem("TWPGanttGridState"));
        }
    }

    function loadGridState() {
        //console.debug("loadGridState")
        if (localStorage) {
            if (localStorage.getObject("TWPGanttGridState")) {
                var gridState = localStorage.getObject("TWPGanttGridState");
                if (gridState.colSizes) {
                    box.find(".gdfTable .gdfColHeader").each(function (i) {
                        $(this).width(gridState.colSizes[i]);
                    });
                }
            }
        }
    }

    loadGridState();
    return box;
};




$.splittify = {
    init: function (where, first, second, perc) {

        //perc = perc || 50;

        var element = $("<div>").addClass("splitterContainer");
        var firstBox = $("<div>").addClass("splitElement splitBox1");
        var splitterBar = $("<div>").addClass("splitElement vSplitBar").attr("unselectable", "on").css("padding-top", where.height() / 2 + "px");
        var secondBox = $("<div>").addClass("splitElement splitBox2");


        var splitter = new Splitter(element, firstBox, secondBox, splitterBar);
        splitter.perc =  perc;

        //override with saved one
        loadPosition();

        var toLeft = $("<div>").addClass("toLeft").html("{").click(function () {splitter.resize(0.001, 300);});
        splitterBar.append(toLeft);

        var toCenter = $("<div>").addClass("toCenter").html("&#xa9;").click(function () {splitter.resize(50, 300);});
        splitterBar.append(toCenter);

        var toRight = $("<div>").addClass("toRight").html("}").click(function () {splitter.resize(99.9999, 300);});
        splitterBar.append(toRight);


        firstBox.append(first);
        secondBox.append(second);

        element.append(firstBox).append(secondBox).append(splitterBar);

        where.append(element);

        var totalW = where.innerWidth();
        var splW = splitterBar.width();
        var fbw = totalW * perc / 100 - splW;
        //var realW = firstBox.get(0).scrollWidth;
        //fbw = fbw > realW? realW: fbw;
        fbw = fbw > totalW - splW - splitter.secondBoxMinWidth ? totalW - splW - splitter.secondBoxMinWidth : fbw;
        firstBox.width(fbw).css({left: 0});
        splitterBar.css({left: firstBox.width()});
        secondBox.width(totalW - fbw - splW).css({left: firstBox.width() + splW});

        splitterBar.on("mousedown.gdf", function (e) {

            e.preventDefault();
            $("body").addClass("gdfHResizing");

            $.splittify.splitterBar = $(this);
            //on event for start resizing
            //console.debug("start splitting");
            //var realW = firstBox.get(0).scrollWidth;
            $("body").unselectable().on("mousemove.gdf", function (e) {
                //manage resizing
                //console.debug(e.pageX - $.gridify.columInResize.offset().left)

                e.preventDefault();

                var sb = $.splittify.splitterBar;
                var pos = e.pageX - sb.parent().offset().left;
                var w = sb.parent().width();
                var fbw = firstBox;

                pos = pos > splitter.firstBoxMinWidth ? pos : splitter.firstBoxMinWidth;
                //pos = pos < realW - 10 ? pos : realW - 10;
                pos = pos > totalW - splW - splitter.secondBoxMinWidth ? totalW - splW - splitter.secondBoxMinWidth : pos;
                sb.css({left: pos});
                firstBox.width(pos);
                secondBox.css({left: pos + sb.width(), width: w - pos - sb.width()});
                splitter.perc = (firstBox.width() / splitter.element.width()) * 100;

                //on mouse up on body to stop resizing
            }).on("mouseup.gdf", function () {
                //console.debug("stop splitting");
                $(this).off("mousemove.gdf").off("mouseup.gdf").clearUnselectable();
                delete $.splittify.splitterBar;

                $("body").removeClass("gdfHResizing");

                storePosition();
            });
        });


        // keep both side in synch when scroll
        var stopScroll = false;
        var fs = firstBox.add(secondBox);
        fs.scroll(function (e) {
            var el = $(this);
            var top = el.scrollTop();
            if (el.is(".splitBox1") && stopScroll != "splitBox2") {
                stopScroll = "splitBox1";
                secondBox.scrollTop(top);
            } else if (el.is(".splitBox2") && stopScroll != "splitBox1") {
                stopScroll = "splitBox2";
                firstBox.scrollTop(top);
            }
            firstBox.find(".ganttFixHead").css('top', top);
            secondBox.find(".ganttFixHead").css('top', top);

            where.stopTime("reset").oneTime(100, "reset", function () {stopScroll = "";})
        });


        firstBox.on('mousewheel MozMousePixelScroll', function (event) {

            event.preventDefault();

            var deltaY = event.originalEvent.wheelDeltaY;
            var deltaX = event.originalEvent.wheelDeltaX;

            if (event.originalEvent.axis) {
                deltaY = event.originalEvent.axis == 2 ? -event.originalEvent.detail : null;
                deltaX = event.originalEvent.axis == 1 ? -event.originalEvent.detail : null;
            }

            deltaY = Math.abs(deltaY) < 40 ? 40 * (Math.abs(deltaY) / deltaY) : deltaY;
            deltaX = Math.abs(deltaX) < 40 ? 40 * (Math.abs(deltaX) / deltaX) : deltaX;

            var scrollToY = secondBox.scrollTop() - deltaY;
            var scrollToX = firstBox.scrollLeft() - deltaX;

//			console.debug( firstBox.scrollLeft(), Math.abs(deltaX), Math.abs(deltaY));

            if (deltaY) secondBox.scrollTop(scrollToY);
            if (deltaX) firstBox.scrollLeft(scrollToX);

            return false;
        });


        function Splitter(element, firstBox, secondBox, splitterBar) {
            this.element = element;
            this.firstBox = firstBox;
            this.secondBox = secondBox;
            this.splitterBar = splitterBar;
            this.perc = 0;
            this.firstBoxMinWidth = 0;
            this.secondBoxMinWidth = 30;

            this.resize = function (newPerc, anim) {
                var animTime = anim ? anim : 0;
                this.perc = newPerc ? newPerc : this.perc;
                var totalW = this.element.width();
                var splW = this.splitterBar.width();
                var newW = totalW * this.perc / 100;
                newW = newW > this.firstBoxMinWidth ? newW : this.firstBoxMinWidth;
                newW = newW > totalW - splW - splitter.secondBoxMinWidth ? totalW - splW - splitter.secondBoxMinWidth : newW;
                this.firstBox.animate({width: newW}, animTime, function () {$(this).css("overflow-x", "auto")});
                this.splitterBar.animate({left: newW}, animTime);
                this.secondBox.animate({left: newW + this.splitterBar.width(), width: totalW - newW - splW}, animTime, function () {$(this).css("overflow", "auto")});

                storePosition();
            };

            var self = this;
            this.splitterBar.on("dblclick", function () {
                self.resize(50, true);
            })
        }


        function storePosition () {
            //console.debug("storePosition",splitter.perc);
            if (localStorage) {
                localStorage.setItem("TWPGanttSplitPos",splitter.perc);
            }
        }

        function loadPosition () {
            //console.debug("loadPosition");
            if (localStorage) {
                if (localStorage.getItem("TWPGanttSplitPos")) {
                    splitter.perc=parseFloat(localStorage.getItem("TWPGanttSplitPos"));
                }
            }
        }



        return splitter;
    }

};


//<%------------------------------------------------------------------------  UTILITIES ---------------------------------------------------------------%>
function computeStart(start) {
    return computeStartDate(start).getTime();
}
function computeStartDate(start) {
    var d = new Date(start + 3600000 * 12);
    d.setHours(0, 0, 0, 0);
    //move to next working day
    while (isHoliday(d)) {
        d.setDate(d.getDate() + 1);
    }
    d.setHours(0, 0, 0, 0);
    return d;
}

function computeEnd(end) {
    return computeEndDate(end).getTime()
}
function computeEndDate(end) {
    var d = new Date(end - 3600000 * 12);
    d.setHours(23, 59, 59, 999);
    //move to next working day
    while (isHoliday(d)) {
        d.setDate(d.getDate() + 1);
    }
    d.setHours(23, 59, 59, 999);
    return d;
}

function computeEndByDuration(start, duration) {
    var d = new Date(start);
    //console.debug("computeEndByDuration start ",d,duration)
    var q = duration - 1;
    while (q > 0) {
        d.setDate(d.getDate() + 1);
        if (!isHoliday(d))
            q--;
    }
    d.setHours(23, 59, 59, 999);
    return d.getTime();
}


function incrementDateByWorkingDays(date, days) {
    var d = new Date(date);
    d.incrementDateByWorkingDays(days);
    return d.getTime();
}


function recomputeDuration(start, end) {
    //console.debug("recomputeDuration");
    return new Date(start).distanceInWorkingDays(new Date(end)) + 1;
}


function resynchDates(leavingField, startField, startMilesField, durationField, endField, endMilesField) {
    //console.debug("resynchDates",leavingField.prop("name"), startField.prop("name"), startMilesField.prop("name"), durationField.prop("name"), endField.prop("name"), endMilesField.prop("name"));
    function resynchDatesSetFields(command) {
        //console.debug("resynchDatesSetFields",command);
        //var duration = parseInt(durationField.val());
        var duration = daysFromString(durationField.val(), true);
        if (!duration || duration < 1)
            duration = 1;

        var start = computeStart(Date.parseString(startField.val()).getTime());

        var end = endField.val();
        if (end.length > 0) {
            end = Date.parseString(end);
            end.setHours(23, 59, 59, 999);
            end = computeEnd(end.getTime());
        }

        var date = new Date();
        if ("CHANGE_END" == command) {
            date.setTime(start);
            var workingDays = duration - 1;
            date.incrementDateByWorkingDays(workingDays);
            date.setHours(23, 59, 59, 999);
            end = computeEnd(date.getTime());
        } else if ("CHANGE_START" == command) {
            date.setTime(end);
            var workingDays = duration - 1;
            date.incrementDateByWorkingDays(-workingDays);
            date.setHours(0, 0, 0, 0);
            start = computeStart(date.getTime());
        } else if ("CHANGE_DURATION" == command) {
            //console.debug("CHANGE_DURATION",new Date(start),new Date(end))
            duration = new Date(start).distanceInWorkingDays(new Date(end)) + 1;
        }

        startField.val(new Date(start).format());
        endField.val(new Date(end).format());
        durationField.val(duration);

        return {start: start, end: end, duration: duration};
    }

    var leavingFieldName = leavingField.prop("name");
    var durIsFilled = durationField.val().length > 0;
    var startIsFilled = startField.val().length > 0;
    var endIsFilled = endField.val().length > 0;
    var startIsMilesAndFilled = startIsFilled && (startMilesField.prop("checked") || startField.is("[readOnly]"));
    var endIsMilesAndFilled = endIsFilled && (endMilesField.prop("checked") || endField.is("[readOnly]"));

    if (durIsFilled) {
        if (parseInt(durationField.val()) == NaN || parseInt(durationField.val()) < 1)
            durationField.val(1);
    }

    if (leavingFieldName.indexOf("Milestone") > 0) {
        if (startIsMilesAndFilled && endIsMilesAndFilled) {
            durationField.prop("readOnly", true);
        } else {
            durationField.prop("readOnly", false);
        }
        return;
    }

    //need at least two values to resynch the third
    if ((durIsFilled ? 1 : 0) + (startIsFilled ? 1 : 0) + (endIsFilled ? 1 : 0) < 2)
        return;

    var ret;
    if (leavingFieldName == 'start' && startIsFilled) {
        if (endIsMilesAndFilled && durIsFilled) {
            ret = resynchDatesSetFields("CHANGE_DURATION");
        } else if (durIsFilled) {
            ret = resynchDatesSetFields("CHANGE_END");
        }

    } else if (leavingFieldName == 'duration' && durIsFilled && !(endIsMilesAndFilled && startIsMilesAndFilled)) {
        if (endIsMilesAndFilled && !startIsMilesAndFilled) {
            ret = resynchDatesSetFields("CHANGE_START");
        } else if (!endIsMilesAndFilled) {
            //document.title=('go and change end!!');
            ret = resynchDatesSetFields("CHANGE_END");
        }

    } else if (leavingFieldName == 'end' && endIsFilled) {
        ret = resynchDatesSetFields("CHANGE_DURATION");
    }
    return ret;
}


//This prototype is provided by the Mozilla foundation and
//is distributed under the MIT license.
//http://www.ibiblio.org/pub/Linux/LICENSES/mit.license

if (!Array.prototype.filter) {
    Array.prototype.filter = function (fun) {
        var len = this.length;
        if (typeof fun != "function")
            throw new TypeError();

        var res = new Array();
        var thisp = arguments[1];
        for (var i = 0; i < len; i++) {
            if (i in this) {
                var val = this[i]; // in case fun mutates this
                if (fun.call(thisp, val, i, this))
                    res.push(val);
            }
        }
        return res;
    };
}


function goToPage(url) {
    if (!canILeave()) return;
    window.location.href = url;
}




/*
 Copyright (c) 2012-2017 Open Lab
 Written by Roberto Bicchierai and Silvia Chelazzi http://roberto.open-lab.com
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * A method to instantiate valid task models from
 * raw data.
 */
function TaskFactory() {

    /**
     * Build a new Task
     */
    this.build = function (id, name, code, level, start, duration, collapsed) {
        // Set at beginning of day
        var adjusted_start = computeStart(start);
        var calculated_end = computeEndByDuration(adjusted_start, duration);

        return new Task(id, name, code, level, adjusted_start, calculated_end, duration, collapsed);
    };

}

function Task(id, name, code, level, start, end, duration, collapsed) {
    this.id = id;
    this.name = name;
    this.progress = 0;
    this.progressByWorklog = false;
    this.relevance = 0;
    this.type = "";
    this.typeId = "";
    this.description = "";
    this.code = code;
    this.level = level;
    this.status = "STATUS_UNDEFINED";
    this.depends = "";
    this.canWrite = true; // by default all tasks are writeable

    this.start = start;
    this.duration = duration;
    this.end = end;

    this.startIsMilestone = false;
    this.endIsMilestone = false;

    this.collapsed = collapsed;

    this.rowElement; //row editor html element
    this.ganttElement; //gantt html element
    this.master;


    this.assigs = [];
}

Task.prototype.clone = function () {
    var ret = {};
    for (var key in this) {
        if (typeof(this[key]) != "function") {
            ret[key] = this[key];
        }
    }
    return ret;
};

Task.prototype.getAssigsString = function () {
    var ret = "";
    for (var i = 0; i < this.assigs.length; i++) {
        var ass = this.assigs[i];
        var res = this.master.getResource(ass.resourceId);
        if (res) {
            ret = ret + (ret == "" ? "" : ", ") + res.name;
        }
    }
    return ret;
};

Task.prototype.createAssignment = function (id, resourceId, roleId, effort) {
    var assig = new Assignment(id, resourceId, roleId, effort);
    this.assigs.push(assig);
    return assig;
};


//<%---------- SET PERIOD ---------------------- --%>
Task.prototype.setPeriod = function (start, end) {
    //console.debug("setPeriod ",this.code,this.name,new Date(start), new Date(end));
    //var profilerSetPer = new Profiler("gt_setPeriodJS");

    if (start instanceof Date) {
        start = start.getTime();
    }

    if (end instanceof Date) {
        end = end.getTime();
    }

    var originalPeriod = {
        start:    this.start,
        end:      this.end,
        duration: this.duration
    };


    //compute legal start/end //todo mossa qui R&S 30/3/2016 perchè altrimenti il calcolo della durata, che è stato modificato sommando giorni, sbaglia
    start = computeStart(start);
    end=computeEnd(end);

    var newDuration = recomputeDuration(start, end);

    //if are equals do nothing and return true
    if ( start == originalPeriod.start && end == originalPeriod.end && newDuration == originalPeriod.duration) {
        //console.debug("Periods are identical!")
        return true;
    }

    if (newDuration == this.duration) { // is shift
        return this.moveTo(start, false);
    }

    //console.debug("setStart",date,date instanceof Date);
    var wantedStartMillis = start;

    //cannot start after end
    if (start > end) {
        start = end;
    }

    //set a legal start
    //start = computeStart(start); //todo R&S 30/3/2016 messo in vetta

    //if there are dependencies compute the start date and eventually moveTo
    var startBySuperiors = this.computeStartBySuperiors(start);
    if (startBySuperiors != start) {
        return this.moveTo(startBySuperiors, false);
    }

    var somethingChanged = false;

    if (this.start != start || this.start != wantedStartMillis) {
        this.start = start;
        somethingChanged = true;
    }

    //set end
    var wantedEndMillis = end;

    //end = computeEnd(end);//todo R&S 30/3/2016 messo in vetta

    if (this.end != end || this.end != wantedEndMillis) {
        this.end = end;
        somethingChanged = true;
    }

    this.duration = recomputeDuration(this.start, this.end);

    //profilerSetPer.stop();

    //nothing changed exit
    if (!somethingChanged)
        return true;

    //cannot write exit
    if (!this.canWrite) {
        this.master.setErrorOnTransaction("\"" + this.name + "\"\n" + GanttMaster.messages["CANNOT_WRITE"], this);
        return false;
    }

    //external dependencies: exit with error
    if (this.hasExternalDep) {
        this.master.setErrorOnTransaction("\"" + this.name + "\"\n" + GanttMaster.messages["TASK_HAS_EXTERNAL_DEPS"], this);
        return false;
    }

    var todoOk = true;

    //I'm restricting
    var deltaPeriod = originalPeriod.duration - this.duration;
    var restricting = deltaPeriod > 0;
    var restrictingStart = restricting && (originalPeriod.start < this.start);
    var restrictingEnd = restricting && (originalPeriod.end > this.end);

    //console.debug( " originalPeriod.duration "+ originalPeriod.duration +" deltaPeriod "+deltaPeriod+" "+"restricting "+restricting);

    if (restricting) {
        //loops children to get boundaries
        var children = this.getChildren();
        var bs = Infinity;
        var be = 0;
        for (var i = 0; i < children.length; i++) {

            var ch = children[i];
            //console.debug("restricting: test child "+ch.name+" "+ch.end)
            if (restrictingEnd) {
                be = Math.max(be, ch.end);
            } else {
                bs = Math.min(bs, ch.start);
            }
        }

        if (restrictingEnd) {
            //console.debug("restricting end ",be, this.end);
            this.end = Math.max(be, this.end);
        } else {
            //console.debug("restricting start");
            this.start = Math.min(bs, this.start);
        }

        this.duration = recomputeDuration(this.start, this.end);
    } else {

        //check global boundaries
        if (this.start < this.master.minEditableDate || this.end > this.master.maxEditableDate) {
            this.master.setErrorOnTransaction("\"" + this.name + "\"\n" +GanttMaster.messages["CHANGE_OUT_OF_SCOPE"], this);
            todoOk = false;
        }

        //console.debug("set period: somethingChanged",this);
        if (todoOk && !updateTree(this)) {
            todoOk = false;
        }
    }

    if (todoOk) {
        todoOk = this.propagateToInferiors(end);
    }
    return todoOk;
};


//<%---------- MOVE TO ---------------------- --%>
Task.prototype.moveTo = function (start, ignoreMilestones) {
    //console.debug("moveTo ",this.code,this.name,new Date(start),this.duration,ignoreMilestones);
    //var profiler = new Profiler("gt_task_moveTo");

    if (start instanceof Date) {
        start = start.getTime();
    }

    var originalPeriod = {
        start: this.start,
        end:   this.end
    };

    var wantedStartMillis = start;

    //set a legal start
    start = computeStart(start);

    //if start is milestone cannot be move
    if (!ignoreMilestones && this.startIsMilestone && start != this.start) {
        //notify error
        this.master.setErrorOnTransaction("\"" + this.name + "\"\n" +GanttMaster.messages["START_IS_MILESTONE"], this);
        return false;
    } else if (this.hasExternalDep) {
        //notify error
        this.master.setErrorOnTransaction("\"" + this.name + "\"\n" +GanttMaster.messages["TASK_HAS_EXTERNAL_DEPS"], this);
        return false;
    }

    //if depends, start is set to max end + lag of superior
    var startBySuperiors = this.computeStartBySuperiors(start);


    //todo if there are dependencies the new start,end must be contained into parent dates
    /*var parent=this.getParent();
     if (start!=startBySuperiors){
     var proposedEnd = computeEndByDuration(startBySuperiors, this.duration);
     // if outside parent's scoce error
     if (parent && (startBySuperiors<parent.start || proposedEnd>parent.end)) {
     this.master.setErrorOnTransaction("\"" + this.name + "\"\n" +GanttMaster.messages["CANNOT_MOVE_TASK"], this);
     return false;
     } else {
     start = startBySuperiors;
     }
     }*/

    start = startBySuperiors;


    var end = computeEndByDuration(start, this.duration);


    if (this.start != start || this.start != wantedStartMillis) {
        /*//in case of end is milestone it never changes, but recompute duration
         if (!ignoreMilestones && this.endIsMilestone) {
         end = this.end;
         this.duration = recomputeDuration(start, end);
         }*/
        //in case of end is milestone it never changes!
        if (!ignoreMilestones && this.endIsMilestone && end!=this.end) {
            this.master.setErrorOnTransaction("\"" + this.name + "\"\n" +GanttMaster.messages["END_IS_MILESTONE"], this);
            return false;
        }
        this.start = start;
        this.end = end;
        //profiler.stop();

        //check global boundaries
        if (this.start < this.master.minEditableDate || this.end > this.master.maxEditableDate) {
            this.master.setErrorOnTransaction("\"" + this.name + "\"\n" +GanttMaster.messages["CHANGE_OUT_OF_SCOPE"], this);
            return false;
        }


        // bicch 22/4/2016: quando si sposta un task con child a cavallo di holidays, i figli devono essere shiftati in workingDays, non in millisecondi, altrimenti si cambiano le durate
        // when moving children you MUST consider WORKING days,
        var panDeltaInWD = new Date(originalPeriod.start).distanceInWorkingDays(new Date(this.start));

        //loops children to shift them
        var children = this.getChildren();
        for (var i = 0; i < children.length; i++) {
            ch = children[i];
            var chStart=new Date(ch.start).incrementDateByWorkingDays(panDeltaInWD);
            if (!ch.moveTo(chStart, false)) {
                //console.debug("esco")
                return false;
            }
        }


        //console.debug("set period: somethingChanged",this);
        if (!updateTree(this)) {
            return false;
        }

        return this.propagateToInferiors(end);
    }

    return true;
};


//<%---------- PROPAGATE TO INFERIORS ---------------------- --%>
Task.prototype.propagateToInferiors = function (end) {
    //and now propagate to inferiors
    var todoOk = true;
    var infs = this.getInferiors();
    if (infs && infs.length > 0) {
        for (var i = 0; i < infs.length; i++) {
            var link = infs[i];
            if (!link.to.canWrite) {
                this.master.setErrorOnTransaction(GanttMaster.messages["CANNOT_WRITE"] + "\n\"" + link.to.name + "\"", link.to);
                break;
            }
            todoOk = link.to.moveTo(end, false); //this is not the right date but moveTo checks start
            if (!todoOk)
                break;
        }
    }
    return todoOk;
};


//<%---------- COMPUTE START BY SUPERIORS ---------------------- --%>
Task.prototype.computeStartBySuperiors = function (proposedStart) {
    //if depends -> start is set to max end + lag of superior
    var supEnd=proposedStart;
    var sups = this.getSuperiors();
    if (sups && sups.length > 0) {
        supEnd=0;
        for (var i = 0; i < sups.length; i++) {
            var link = sups[i];
            supEnd = Math.max(supEnd, incrementDateByWorkingDays(link.from.end, link.lag));
        }
        supEnd+=1;
    }
    return computeStart(supEnd);
};


function updateTree(task) {
    //console.debug("updateTree ",task.code,task.name);
    var error;

    //try to enlarge parent
    var p = task.getParent();

    //no parent:exit
    if (!p)
        return true;

    var newStart = p.start;
    var newEnd = p.end;

    if (p.start > task.start) {
        if (p.startIsMilestone) {
            task.master.setErrorOnTransaction("\"" + p.name + "\"\n" + GanttMaster.messages["START_IS_MILESTONE"], task);
            return false;
        } else if (p.depends) {
            task.master.setErrorOnTransaction("\"" + p.name + "\"\n" + GanttMaster.messages["TASK_HAS_CONSTRAINTS"], task);
            return false;
        }

        newStart = task.start;
    }
    if (p.end < task.end) {
        if (p.endIsMilestone) {
            task.master.setErrorOnTransaction("\"" + p.name + "\"\n" + GanttMaster.messages["END_IS_MILESTONE"], task);
            return false;
        }

        newEnd = task.end;
    }

    //propagate updates if needed
    if (newStart != p.start || newEnd != p.end) {

        //can write?
        if (!p.canWrite) {
            task.master.setErrorOnTransaction(GanttMaster.messages["CANNOT_WRITE"] + "\n" + p.name, task);
            return false;
        }

        //has external deps ?
        if (p.hasExternalDep) {
            task.master.setErrorOnTransaction(GanttMaster.messages["TASK_HAS_EXTERNAL_DEPS"] + "\n\"" + p.name + "\"", task);
            return false;
        }

        return p.setPeriod(newStart, newEnd);
    }

    return true;
}


//<%---------- CHANGE STATUS ---------------------- --%>
Task.prototype.changeStatus = function (newStatus,forceStatusCheck) {
    //console.debug("changeStatus: "+this.name+" from "+this.status+" -> "+newStatus);

    var cone = this.getDescendant();

    function propagateStatus(task, newStatus, manuallyChanged, propagateFromParent, propagateFromChildren) {
        //console.debug("propagateStatus",task.name, task.status,newStatus, manuallyChanged, propagateFromParent, propagateFromChildren);
        var oldStatus = task.status;

        //no changes exit
        if (newStatus == oldStatus && !forceStatusCheck) {
            return true;
        }

        var todoOk = true;
        task.status = newStatus;


        //xxxx -> STATUS_DONE            may activate dependent tasks, both suspended and undefined. Will set to done all children.
        //STATUS_FAILED -> STATUS_DONE   do nothing if not forced by hand
        if (newStatus == "STATUS_DONE") {

            // cannot close task if open issues
            if (task.master.permissions.cannotCloseTaskIfIssueOpen && task.openIssues > 0) {
                task.master.setErrorOnTransaction(GanttMaster.messages["CANNOT_CLOSE_TASK_IF_OPEN_ISSUE"] + " \"" + task.name + "\"");
                return false;
            }


            if ((manuallyChanged || oldStatus != "STATUS_FAILED")) { //cannot set failed task as closed for cascade - only if changed manually

                //can be closed only if superiors are already done
                var sups = task.getSuperiors();
                for (var i = 0; i < sups.length; i++) {
                    if (sups[i].from.status != "STATUS_DONE" && cone.indexOf(sups[i].from)<0) { // è un errore se un predecessore è non chiuso ed è fuori dal cono
                        if (manuallyChanged || propagateFromParent)  //genere un errore bloccante se è cambiato a mano o se il cambiamento arriva dal parent ed ho una dipendenza fuori dal cono (altrimenti avrei un attivo figlio di un chiuso
                            task.master.setErrorOnTransaction(GanttMaster.messages["GANTT_ERROR_DEPENDS_ON_OPEN_TASK"] + "\n\"" + sups[i].from.name + "\" -> \"" + task.name + "\"");
                        todoOk = false;
                        break;
                    }
                }

                if (todoOk) {
                    // set progress to 100% if needed by settings
                    if (task.master.set100OnClose && !task.progressByWorklog ){
                        task.progress=100;
                    }

                    //set children as done
                    propagateStatusToChildren(task,newStatus,false);

                    //set inferiors as active
                    propagateStatusToInferiors( task.getInferiors(), "STATUS_ACTIVE");
                }
            } else { // una propagazione tenta di chiudere un task fallito
                todoOk = false;
            }


            //  STATUS_UNDEFINED -> STATUS_ACTIVE       all children become active, if they have no dependencies.
            //  STATUS_SUSPENDED -> STATUS_ACTIVE       sets to active all children and their descendants that have no inhibiting dependencies.
            //  STATUS_DONE -> STATUS_ACTIVE            all those that have dependencies must be set to suspended.
            //  STATUS_FAILED -> STATUS_ACTIVE          nothing happens: child statuses must be reset by hand.
        } else if (newStatus == "STATUS_ACTIVE") {

            if ((manuallyChanged || oldStatus != "STATUS_FAILED")) { //cannot set failed task as closed for cascade - only if changed manually

                //can be active only if superiors are already done, not only on this task, but also on ancestors superiors
                var sups = task.getSuperiors();

                for (var i = 0; i < sups.length; i++) {
                    if (sups[i].from.status != "STATUS_DONE") {
                        if (manuallyChanged || propagateFromChildren)
                            task.master.setErrorOnTransaction(GanttMaster.messages["GANTT_ERROR_DEPENDS_ON_OPEN_TASK"] + "\n\"" + sups[i].from.name + "\" -> \"" + task.name + "\"");
                        todoOk = false;
                        break;
                    }
                }

                // check if parent is already active
                if (todoOk) {
                    var par = task.getParent();
                    if (par && par.status != "STATUS_ACTIVE") {
                        // todoOk = propagateStatus(par, "STATUS_ACTIVE", false, false, true); //todo abbiamo deciso di non far propagare lo status verso l'alto
                        todoOk = false;
                    }
                }


                if (todoOk) {
                    if (oldStatus == "STATUS_UNDEFINED" || oldStatus == "STATUS_SUSPENDED") {
                        //set children as active
                        propagateStatusToChildren(task,newStatus,true);
                    }

                    //set inferiors as suspended
                    propagateStatusToInferiors( task.getInferiors(), "STATUS_SUSPENDED");
                }
            } else {
                todoOk = false;
            }

            // xxxx -> STATUS_SUSPENDED       all active children and their active descendants become suspended. when not failed or forced
        } else if (newStatus == "STATUS_SUSPENDED" ) {
            if (manuallyChanged || oldStatus != "STATUS_FAILED") { //cannot set failed task as closed for cascade - only if changed manually

                //check if parent if not active
                var par = task.getParent();
                if (par && (par.status != "STATUS_ACTIVE" && par.status != "STATUS_SUSPENDED")) {
                    todoOk = false;
                }


                if (todoOk) {
                    //set children as STATUS_SUSPENDED
                    propagateStatusToChildren(task, newStatus, true);

                    //set inferiors as STATUS_SUSPENDED
                    propagateStatusToInferiors( task.getInferiors(), newStatus);
                }
            } else {
                todoOk = false;
            }

            // xxxx -> STATUS_FAILED children and dependent failed
            // xxxx -> STATUS_UNDEFINED  children and dependant become undefined.
        } else if (newStatus == "STATUS_FAILED" || newStatus == "STATUS_UNDEFINED") {

            //set children as failed or undefined
            propagateStatusToChildren(task,newStatus,false);

            //set inferiors as failed
            propagateStatusToInferiors( task.getInferiors(), newStatus);
        }
        if (!todoOk) {
            task.status = oldStatus;
            //console.debug("status rolled back: "+task.name + " to " + oldStatus);
        }

        return todoOk;
    }

    /**
     * A helper method to traverse an array of 'inferior' tasks
     * and signal a status change.
     */
    function propagateStatusToInferiors( infs, status) {
        for (var i = 0; i < infs.length; i++) {
            propagateStatus(infs[i].to, status, false, false, false);
        }
    }

    /**
     * A helper method to loop children and propagate new status
     */
    function propagateStatusToChildren(task, newStatus, skipClosedTasks) {
        var chds = task.getChildren();
        for (var i = 0; i < chds.length; i++)
            if (!(skipClosedTasks && chds[i].status == "STATUS_DONE") )
                propagateStatus(chds[i], newStatus, false, true, false);
    }


    var manuallyChanged=true;

    var oldStatus = this.status;
    //first call
    if (propagateStatus(this, newStatus, manuallyChanged, false, false)) {
        return true;
    } else {
        this.status = oldStatus;
        return false;
    }
};

Task.prototype.synchronizeStatus = function () {
    //console.debug("synchronizeStatus",this.name);
    var oldS = this.status;
    this.status = this.getParent()?this.getParent().status:"STATUS_UNDEFINED"; // di default si invalida lo stato mettendo quello del padre, in modo che inde/outd siano consistenti
    return this.changeStatus(oldS,true);
};

Task.prototype.isLocallyBlockedByDependencies = function () {
    var sups = this.getSuperiors();
    var blocked = false;
    for (var i = 0; i < sups.length; i++) {
        if (sups[i].from.status != "STATUS_DONE") {
            blocked = true;
            break;
        }
    }
    return blocked;
};

//<%---------- TASK STRUCTURE ---------------------- --%>
Task.prototype.getRow = function () {
    ret = -1;
    if (this.master)
        ret = this.master.tasks.indexOf(this);
    return ret;
};


Task.prototype.getParents = function () {
    var ret;
    if (this.master) {
        var topLevel = this.level;
        var pos = this.getRow();
        ret = [];
        for (var i = pos; i >= 0; i--) {
            var par = this.master.tasks[i];
            if (topLevel > par.level) {
                topLevel = par.level;
                ret.push(par);
            }
        }
    }
    return ret;
};


Task.prototype.getParent = function () {
    var ret;
    if (this.master) {
        for (var i = this.getRow(); i >= 0; i--) {
            var par = this.master.tasks[i];
            if (this.level > par.level) {
                ret = par;
                break;
            }
        }
    }
    return ret;
};


Task.prototype.isParent = function () {
    var ret = false;
    if (this.master) {
        var pos = this.getRow();
        if (pos < this.master.tasks.length - 1)
            ret = this.master.tasks[pos + 1].level > this.level;
    }
    return ret;
};


Task.prototype.getChildren = function () {
    var ret = [];
    if (this.master) {
        var pos = this.getRow();
        for (var i = pos + 1; i < this.master.tasks.length; i++) {
            var ch = this.master.tasks[i];
            if (ch.level == this.level + 1)
                ret.push(ch);
            else if (ch.level <= this.level) // exit loop if parent or brother
                break;
        }
    }
    return ret;
};


Task.prototype.getDescendant = function () {
    var ret = [];
    if (this.master) {
        var pos = this.getRow();
        for (var i = pos + 1; i < this.master.tasks.length; i++) {
            var ch = this.master.tasks[i];
            if (ch.level > this.level)
                ret.push(ch);
            else
                break;
        }
    }
    return ret;
};


Task.prototype.getSuperiors = function () {
    var ret = [];
    var task = this;
    if (this.master) {
        ret = this.master.links.filter(function (link) {
            return link.to == task;
        });
    }
    return ret;
};

Task.prototype.getSuperiorTasks = function () {
    var ret = [];
    var sups = this.getSuperiors();
    for (var i = 0; i < sups.length; i++)
        ret.push(sups[i].from);
    return ret;
};


Task.prototype.getInferiors = function () {
    var ret = [];
    var task = this;
    if (this.master) {
        ret = this.master.links.filter(function (link) {
            return link.from == task;
        });
    }
    return ret;
};

Task.prototype.getInferiorTasks = function () {
    var ret = [];
    var infs = this.getInferiors();
    for (var i = 0; i < infs.length; i++)
        ret.push(infs[i].to);
    return ret;
};

Task.prototype.deleteTask = function () {
    //console.debug("deleteTask",this.name,this.master.deletedTaskIds)
    //if is the current one remove it
    if (this.master.currentTask && this.master.currentTask.id==this.id)
        delete this.master.currentTask;

    //delete both dom elements if exists
    if (this.rowElement)
        this.rowElement.remove();
    if (this.ganttElement)
        this.ganttElement.remove();

    //remove children
    var chd = this.getChildren();
    for (var i = 0; i < chd.length; i++) {
        //add removed child in list
        chd[i].deleteTask();
    }

    if (!this.isNew())
        this.master.deletedTaskIds.push(this.id);


    //remove from in-memory collection
    this.master.tasks.splice(this.getRow(), 1);

    //remove from links
    var task = this;
    this.master.links = this.master.links.filter(function (link) {
        return link.from != task && link.to != task;
    });
};


Task.prototype.isNew = function () {
    return (this.id + "").indexOf("tmp_") == 0;
};

Task.prototype.isDependent = function (t) {
    //console.debug("isDependent",this.name, t.name)
    var task = this;
    var dep = this.master.links.filter(function (link) {
        return link.from == task;
    });

    // is t a direct dependency?
    for (var i = 0; i < dep.length; i++) {
        if (dep[i].to == t)
            return true;
    }
    // is t an indirect dependency
    for (var i = 0; i < dep.length; i++) {
        if (dep[i].to.isDependent(t)) {
            return true;
        }
    }
    return false;
};

Task.prototype.setLatest = function (maxCost) {
    this.latestStart = maxCost - this.criticalCost;
    this.latestFinish = this.latestStart + this.duration;
};


//<%------------------------------------------  INDENT/OUTDENT --------------------------------%>
Task.prototype.indent = function () {
    //console.debug("indent", this);
    //a row above must exist
    var row = this.getRow();

    //no row no party
    if (row <= 0)
        return false;

    var ret = false;
    var taskAbove = this.master.tasks[row - 1];
    var newLev = this.level + 1;
    if (newLev <= taskAbove.level + 1) {
        ret = true;

        //trick to get parents after indent
        this.level++;
        var futureParents = this.getParents();
        this.level--;

        var oldLevel = this.level;
        for (var i = row; i < this.master.tasks.length; i++) {
            var desc = this.master.tasks[i];
            if (desc.level > oldLevel || desc == this) {
                desc.level++;
                //remove links from this and descendant to my parents
                this.master.links = this.master.links.filter(function (link) {
                    var linkToParent = false;
                    if (link.to == desc)
                        linkToParent = futureParents.indexOf(link.from) >= 0;
                    else if (link.from == desc)
                        linkToParent = futureParents.indexOf(link.to) >= 0;
                    return !linkToParent;
                });
                //remove links from this and descendants to predecessors of parents in order to avoid loop
                var predecessorsOfFutureParents=[];
                for (var j=0;j<futureParents.length;j++)
                    predecessorsOfFutureParents=predecessorsOfFutureParents.concat(futureParents[j].getSuperiorTasks());

                this.master.links = this.master.links.filter(function (link) {
                    var linkToParent = false;
                    if (link.from == desc)
                        linkToParent = predecessorsOfFutureParents.indexOf(link.to) >= 0;
                    return !linkToParent;
                });


            } else
                break;
        }

        var parent = this.getParent();
        // set start date to parent' start if no deps
        if (parent && !this.depends) {
            var new_end = computeEndByDuration(parent.start, this.duration);
            this.master.changeTaskDates(this, parent.start, new_end);
        }



        //recompute depends string
        this.master.updateDependsStrings();
        //enlarge parent using a fake set period
        updateTree(this);
        //force status check starting from parent
        this.getParent().synchronizeStatus();
    }
    return ret;
};


Task.prototype.outdent = function () {
    //console.debug("outdent", this);

    //a level must be >1 -> cannot escape from root
    if (this.level <= 1)
        return false;

    var ret = false;
    var oldLevel = this.level;

    ret = true;
    var row = this.getRow();
    for (var i = row; i < this.master.tasks.length; i++) {
        var desc = this.master.tasks[i];
        if (desc.level > oldLevel || desc == this) {
            desc.level--;
        } else
            break;
    }

    var task = this;
    var chds = this.getChildren();
    //remove links from me to my new children
    this.master.links = this.master.links.filter(function (link) {
        var linkExist = (link.to == task && chds.indexOf(link.from) >= 0 || link.from == task && chds.indexOf(link.to) >= 0);
        return !linkExist;
    });


    //enlarge me if inherited children are larger
    for (var i = 0; i < chds.length; i++) {
        //remove links from me to my new children
        chds[i].setPeriod(chds[i].start + 1, chds[i].end + 1);
    }

    //recompute depends string
    this.master.updateDependsStrings();

    //enlarge parent using a fake set period
    this.setPeriod(this.start + 1, this.end + 1);

    //force status check
    this.synchronizeStatus();
    return ret;
};


//<%------------------------------------------  MOVE UP / MOVE DOWN --------------------------------%>
Task.prototype.moveUp = function () {
    //console.debug("moveUp", this);
    var ret = false;

    //a row above must exist
    var row = this.getRow();

    //no row no party
    if (row <= 0)
        return false;

    //find new row
    var newRow;
    for (newRow = row - 1; newRow >= 0; newRow--) {
        if (this.master.tasks[newRow].level <= this.level)
            break;
    }

    //is a parent or a brother
    if (this.master.tasks[newRow].level == this.level) {
        ret = true;
        //compute descendant
        var descNumber = 0;
        for (var i = row + 1; i < this.master.tasks.length; i++) {
            var desc = this.master.tasks[i];
            if (desc.level > this.level) {
                descNumber++;
            } else {
                break;
            }
        }
        //move in memory
        var blockToMove = this.master.tasks.splice(row, descNumber + 1);
        var top = this.master.tasks.splice(0, newRow);
        this.master.tasks = [].concat(top, blockToMove, this.master.tasks);
        //move on dom
        var rows = this.master.editor.element.find("tr[taskid]");
        var domBlockToMove = rows.slice(row, row + descNumber + 1);
        rows.eq(newRow).before(domBlockToMove);

        //recompute depends string
        this.master.updateDependsStrings();
    } else {
        this.master.setErrorOnTransaction(GanttMaster.messages["TASK_MOVE_INCONSISTENT_LEVEL"], this);
        ret = false;
    }
    return ret;
};


Task.prototype.moveDown = function () {
    //console.debug("moveDown", this);

    //a row below must exist, and cannot move root task
    var row = this.getRow();
    if (row >= this.master.tasks.length - 1 || row == 0)
        return false;

    var ret = false;

    //find nearest brother
    var newRow;
    for (newRow = row + 1; newRow < this.master.tasks.length; newRow++) {
        if (this.master.tasks[newRow].level <= this.level)
            break;
    }

    //is brother
    if (this.master.tasks[newRow] && this.master.tasks[newRow].level == this.level) {
        ret = true;
        //find last desc
        for (newRow = newRow + 1; newRow < this.master.tasks.length; newRow++) {
            if (this.master.tasks[newRow].level <= this.level)
                break;
        }

        //compute descendant
        var descNumber = 0;
        for (var i = row + 1; i < this.master.tasks.length; i++) {
            var desc = this.master.tasks[i];
            if (desc.level > this.level) {
                descNumber++;
            } else {
                break;
            }
        }

        //move in memory
        var blockToMove = this.master.tasks.splice(row, descNumber + 1);
        var top = this.master.tasks.splice(0, newRow - descNumber - 1);
        this.master.tasks = [].concat(top, blockToMove, this.master.tasks);


        //move on dom
        var rows = this.master.editor.element.find("tr[taskid]");
        var aft = rows.eq(newRow - 1);
        var domBlockToMove = rows.slice(row, row + descNumber + 1);
        aft.after(domBlockToMove);

        //recompute depends string
        this.master.updateDependsStrings();
    }

    return ret;
};


//<%------------------------------------------------------------------------  LINKS OBJECT ---------------------------------------------------------------%>
function Link(taskFrom, taskTo, lagInWorkingDays) {
    this.from = taskFrom;
    this.to = taskTo;
    this.lag = lagInWorkingDays;
}


//<%------------------------------------------------------------------------  ASSIGNMENT ---------------------------------------------------------------%>
function Assignment(id, resourceId, roleId, effort) {
    this.id = id;
    this.resourceId = resourceId;
    this.roleId = roleId;
    this.effort = effort;
}


//<%------------------------------------------------------------------------  RESOURCE ---------------------------------------------------------------%>
function Resource(id, name) {
    this.id = id;
    this.name = name;
}


//<%------------------------------------------------------------------------  ROLE ---------------------------------------------------------------%>
function Role(id, name) {
    this.id = id;
    this.name = name;
}






/*
 Copyright (c) 2012-2017 Open Lab
 Written by Roberto Bicchierai and Silvia Chelazzi http://roberto.open-lab.com
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


 todo For compatibility with IE and SVGElements.getElementsByClassName not implemented changed every find starting from SVGElement (the other works fine)
 .find(".classname"))  -> .find("[class*=classname])
 */
function Ganttalendar(zoom, startmillis, endMillis, master, minGanttSize) {
    this.master = master; // is the a GantEditor instance
    this.element; // is the jquery element containing gantt

    this.svg; // instance of svg object containing gantt
    this.tasksGroup; //instance of svg group containing tasks
    this.linksGroup; //instance of svg group containing links

    this.zoom = zoom;
    this.minGanttSize = minGanttSize;
    this.includeToday = true; //when true today is always visible. If false boundaries comes from tasks periods
    this.showCriticalPath = false; //when true critical path is highlighted

    this.zoomLevels = [ "d", "w","w2","w3", "m","m2", "q", "q2", "s", "y"];

    this.element = this.create(zoom, startmillis, endMillis);

    this.linkOnProgress = false; //set to true when creating a new link

    this.rowHeight = 30; // todo get it from css?
    this.taskHeight=20;
    this.taskVertOffset=(this.rowHeight-this.taskHeight)/2;

}

Ganttalendar.prototype.zoomGantt = function (isPlus) {
    var curLevel = this.zoom;
    var pos = this.zoomLevels.indexOf(curLevel + "");

    var centerMillis=this.getCenterMillis();
    var newPos = pos;
    if (isPlus) {
        newPos = pos <= 0 ? 0 : pos - 1;
    } else {
        newPos = pos >= this.zoomLevels.length - 1 ? this.zoomLevels.length - 1 : pos + 1;
    }
    if (newPos != pos) {
        curLevel = this.zoomLevels[newPos];
        this.zoom = curLevel;
        this.refreshGantt();
        this.goToMillis(centerMillis);
    }
};


Ganttalendar.prototype.create = function (zoom, originalStartmillis, originalEndMillis) {
    //console.debug("Gantt.create " + new Date(originalStartmillis) + " - " + new Date(originalEndMillis));
    var self = this;

    function getPeriod(zoomLevel, stMil, endMillis) {
        var start = new Date(stMil);
        var end = new Date(endMillis);

        start.setHours(0, 0, 0, 0);
        end.setHours(23, 59, 59, 999);

        //reset hours
        if (zoomLevel == "d") {
            start.setFirstDayOfThisWeek();
            end.setFirstDayOfThisWeek();
            end.setDate(end.getDate() + 6);

            //reset day of week
        } else if (zoomLevel == "w" ) {
            start.setFirstDayOfThisWeek();
            start.setDate(start.getDate()-7);
            end.setFirstDayOfThisWeek();
            end.setDate(end.getDate() + 13);

        } else if (zoomLevel == "w2" ) {
            start.setFirstDayOfThisWeek();
            start.setDate(start.getDate()-7);
            end.setFirstDayOfThisWeek();
            end.setDate(end.getDate() + 20);

        } else if (zoomLevel == "w3" ) {
            start.setFirstDayOfThisWeek();
            start.setDate(start.getDate()-7);
            end.setFirstDayOfThisWeek();
            end.setDate(end.getDate() + 27);

            //reset day of month
        } else if (zoomLevel == "m") {
            start.setDate(1);
            start.setMonth(start.getMonth()-1);
            end.setDate(1);
            end.setMonth(end.getMonth() + 2);
            end.setDate(end.getDate() - 1);

        } else if (zoomLevel == "m2") {
            start.setDate(1);
            start.setMonth(start.getMonth()-1);
            end.setDate(1);
            end.setMonth(end.getMonth() + 3);
            end.setDate(end.getDate() - 1);

            //reset to day of week
        } else if (zoomLevel == "q") {
            start.setDate(start.getDate()-start.getDay()+1); //ISO 8601 counts week of year starting on Moday
            start.setDate(start.getDate()-7);
            end.setFirstDayOfThisWeek();
            end.setDate(end.getDate() + 13);

            //reset to quarter
        } else if (zoomLevel == "q2") {
            start.setDate(1);
            start.setMonth(Math.floor(start.getMonth() / 3) * 3);
            start.setMonth(start.getMonth()-3);
            end.setDate(1);
            end.setMonth(Math.floor(end.getMonth() / 3) * 3 + 6);
            end.setDate(end.getDate() - 1);

            //reset to semester
        } else if (zoomLevel == "s") {
            start.setDate(1);
            start.setMonth(Math.floor(start.getMonth() / 6) * 6);
            start.setMonth(start.getMonth()-6);
            end.setDate(1);
            end.setMonth(Math.floor(end.getMonth() / 6) * 6 + 12);
            end.setDate(end.getDate() - 1);

            //reset to year - > gen
        } else if (zoomLevel == "y") {
            start.setDate(1);
            start.setMonth(0);
            start.setFullYear(start.getFullYear()-1);
            end.setDate(1);
            end.setMonth(24);
            end.setDate(end.getDate() - 1);
        }
        return {start:start.getTime(), end:end.getTime()};
    }

    function createHeadCell(lbl, span, additionalClass, width) {
        var th = $("<th>").html(lbl).attr("colSpan", span);
        if (width)
            th.width(width);
        if (additionalClass)
            th.addClass(additionalClass);
        return th;
    }

    function createBodyCell(span, isEnd, additionalClass) {
        var ret = $("<td>").html("").attr("colSpan", span).addClass("ganttBodyCell");
        if (isEnd)
            ret.addClass("end");
        if (additionalClass)
            ret.addClass(additionalClass);
        return ret;
    }

    function createGantt(zoom, startPeriod, endPeriod) {
        var tr1 = $("<tr>").addClass("ganttHead1");
        var tr2 = $("<tr>").addClass("ganttHead2");
        var trBody = $("<tr>").addClass("ganttBody");

        function iterate(renderFunction1, renderFunction2) {
            var start = new Date(startPeriod);
            //loop for header1
            while (start.getTime() <= endPeriod) {
                renderFunction1(start);
            }

            //loop for header2
            start = new Date(startPeriod);
            while (start.getTime() <= endPeriod) {
                renderFunction2(start);
            }
        }

        //this is computed by hand in order to optimize cell size
        var computedTableWidth;
        var computedScaleX;
        // year
        if (zoom == "y") {
            computedScaleX=100/(3600000 * 24*180); //1 sem= 100px
            iterate(function (date) {
                tr1.append(createHeadCell(date.format("yyyy"), 2));
                date.setFullYear(date.getFullYear() + 1);
            }, function (date) {
                var end = new Date(date.getTime());
                end.setMonth(end.getMonth() + 6);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;
                var sem = (Math.floor(date.getMonth() / 6) + 1);
                tr2.append(createHeadCell(GanttMaster.messages["GANTT_SEMESTER_SHORT"] + sem, 1, null, periodWidth));
                trBody.append(createBodyCell(1, sem == 2));
                date.setMonth(date.getMonth() + 6);
            });

            //semester
        } else if (zoom == "s") {
            computedScaleX=200/(3600000 * 24*90); //1 quarter= 200px
            iterate(function (date) {
                var end = new Date(date.getTime());
                end.setMonth(end.getMonth() + 6);
                end.setDate(end.getDate() - 1);
                tr1.append(createHeadCell(date.format("MMMM") + " - " + end.format("MMMM yyyy"), 6));
                date.setMonth(date.getMonth() + 6);
            }, function (date) {
                var end = new Date(date.getTime());
                end.setMonth(end.getMonth() + 1);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;
                tr2.append(createHeadCell(date.format("MMM"), 1, null, periodWidth));
                trBody.append(createBodyCell(1, (date.getMonth()+1) % 6 == 0));
                date.setMonth(date.getMonth() + 1);
            });


            //quarter
        } else if (zoom == "q2") {
            computedScaleX=150/(3600000 * 24*30); //1 month= 150px
            iterate(function (date) {
                var end = new Date(date.getTime());
                end.setMonth(end.getMonth() + 3);
                end.setDate(end.getDate() - 1);
                tr1.append(createHeadCell(date.format("MMMM") + " - " + end.format("MMMM yyyy"), 3));
                date.setMonth(date.getMonth() + 3);
            }, function (date) {
                var end = new Date(date.getTime());
                end.setMonth(end.getMonth() + 1);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;

                var lbl = date.format("MMMM");
                tr2.append(createHeadCell(lbl, 1, null, periodWidth));
                trBody.append(createBodyCell(1, date.getMonth() % 3 == 2));
                date.setMonth(date.getMonth() + 1);
            });

            // quarter / week of year
        } else if (zoom == "q") {
            computedScaleX=300/(3600000 * 24*30); //1 month= 300px
            iterate(function (date) {
                var end = new Date(date.getTime());
                end.setMonth(end.getMonth() + 3);
                end.setDate(end.getDate() - 1);
                tr1.append(createHeadCell(date.format("MMMM") + " - " + end.format("MMMM yyyy"), Math.round((end.getTime()-date.getTime())/(3600000*24))));
                date.setMonth(date.getMonth() + 3);
            }, function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 7);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;
                var lbl ="<small>"+i18n["WEEK_SHORT"].toLowerCase()+"</small> "+ date.format("w");
                tr2.append(createHeadCell(lbl, 7, null, periodWidth));
                trBody.append(createBodyCell(7,false));
                date.setDate(date.getDate() + 7);
            });

            //month
        } else if (zoom == "m2") {
            computedScaleX=15/(3600000 * 24); //1 day= 15px
            iterate(function (date) {
                var sm = date.getTime();
                date.setMonth(date.getMonth() + 1);
                var daysInMonth = Math.round((date.getTime() - sm) / (3600000 * 24));
                tr1.append(createHeadCell(new Date(sm).format("MMMM yyyy"), daysInMonth)); //spans mumber of dayn in the month
            }, function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 1);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;
                tr2.append(createHeadCell(date.format("d"), 1, isHoliday(date) ? "holyH headSmall" : "headSmall", periodWidth));
                var nd = new Date(date.getTime());
                nd.setDate(date.getDate() + 1);
                trBody.append(createBodyCell(1, nd.getDate() == 1, isHoliday(date) ? "holy" : null));
                date.setDate(date.getDate() + 1);
            });

        } else if (zoom == "m") {
            computedScaleX=25/(3600000 * 24); //1 day= 25px

            iterate(function (date) {
                var sm = date.getTime();
                date.setMonth(date.getMonth() + 1);
                var daysInMonth = Math.round((date.getTime() - sm) / (3600000 * 24));
                tr1.append(createHeadCell(new Date(sm).format("MMMM yyyy"), daysInMonth)); //spans mumber of dayn in the month
            }, function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 1);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;
                tr2.append(createHeadCell(date.format("d"), 1, isHoliday(date) ? "holyH" : null, periodWidth));
                var nd = new Date(date.getTime());
                nd.setDate(date.getDate() + 1);
                trBody.append(createBodyCell(1, nd.getDate() == 1, isHoliday(date) ? "holy" : null));
                date.setDate(date.getDate() + 1);
            });

            //week
        } else if (zoom == "w3") {
            computedScaleX=30/(3600000 * 24); //1 day= 30px

            iterate(function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 6);
                tr1.append(createHeadCell(date.format("MMM d") + " - " + end.format("MMM d 'yy"), 7));
                date.setDate(date.getDate() + 7);
            }, function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 1);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;

                tr2.append(createHeadCell(date.format("EEEE").substr(0, 1), 1, isHoliday(date) ? "holyH" : null, periodWidth));
                trBody.append(createBodyCell(1, date.getDay() % 7 == (self.master.firstDayOfWeek + 6) % 7, isHoliday(date) ? "holy" : null));
                date.setDate(date.getDate() + 1);
            });

        } else if (zoom == "w2") {
            computedScaleX=40/(3600000 * 24); //1 day= 40px
            iterate(function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 6);
                tr1.append(createHeadCell(date.format("MMM d") + " - " + end.format("MMM d 'yy"), 7));
                date.setDate(date.getDate() + 7);
            }, function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 1);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;

                tr2.append(createHeadCell(date.format("EEEE").substr(0, 1), 1, isHoliday(date) ? "holyH" : null, periodWidth));
                trBody.append(createBodyCell(1, date.getDay() % 7 == (self.master.firstDayOfWeek + 6) % 7, isHoliday(date) ? "holy" : null));
                date.setDate(date.getDate() + 1);
            });

        } else if (zoom == "w") {
            computedScaleX=50/(3600000 * 24);//1 day= 50px
            iterate(function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 6);
                tr1.append(createHeadCell(date.format("MMM d") + " - " + end.format("MMM d 'yy"), 7));
                date.setDate(date.getDate() + 7);
            }, function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 1);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;
                tr2.append(createHeadCell(date.format("EEEE").substr(0, 1), 1, isHoliday(date) ? "holyH" : null, periodWidth));
                trBody.append(createBodyCell(1, date.getDay() % 7 == (self.master.firstDayOfWeek + 6) % 7, isHoliday(date) ? "holy" : null));
                date.setDate(date.getDate() + 1);
            });

            //days
        } else if (zoom == "d") {
            computedScaleX=100/(3600000 * 24);//1 day= 100px
            iterate(function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 6);
                tr1.append(createHeadCell(date.format("MMMM d") + " - " + end.format("MMMM d yyyy"), 7));
                date.setDate(date.getDate() + 7);
            }, function (date) {
                var end = new Date(date.getTime());
                end.setDate(end.getDate() + 1);
                var periodWidth=(end.getTime()-date.getTime())*computedScaleX;

                tr2.append(createHeadCell(date.format("EEE d"), 1, isHoliday(date) ? "holyH" : null, periodWidth));
                trBody.append(createBodyCell(1, date.getDay() % 7 == (self.master.firstDayOfWeek + 6) % 7, isHoliday(date) ? "holy" : null));
                date.setDate(date.getDate() + 1);
            });

        } else {
            console.error("Wrong level " + zoom);
        }

        computedTableWidth = (endPeriod - startPeriod)*computedScaleX;


        //set a minimal width
        computedTableWidth = Math.max(computedTableWidth, self.minGanttSize);

        var table = $("<table cellspacing=0 cellpadding=0>");
        table.append(tr1).append(tr2);   // removed as on FF there are rounging issues  //.css({width:computedTableWidth});

        var head = table.clone().addClass("ganttFixHead");

        table.append(trBody).addClass("ganttTable");


        var height = self.master.editor.element.height();
        table.height(height);

        var box = $("<div>");
        box.addClass("gantt unselectable").attr("unselectable", "true").css({position:"relative", width:computedTableWidth});
        box.append(table);
        box.append(head);

        //create the svg
        box.svg({settings:{class:"ganttSVGBox"},
            onLoad:         function (svg) {
                //console.debug("svg loaded", svg);

                //creates gradient and definitions
                var defs = svg.defs('myDefs');


                //create backgound
                var extDep = svg.pattern(defs, "extDep", 0, 0, 10, 10, 0, 0, 10, 10, {patternUnits:'userSpaceOnUse'});
                var img=svg.image(extDep, 0, 0, 10, 10, self.master.resourceUrl +"hasExternalDeps.png",{opacity:.3});

                self.svg = svg;
                $(svg).addClass("ganttSVGBox");

                //creates grid group
                var gridGroup = svg.group("gridGroup");

                //creates rows grid
                for (var i = 40; i <= height; i += self.rowHeight)
                    //svg.line(gridGroup, 0, i, "100%", i, {class:"ganttLinesSVG"});
                    svg.rect(gridGroup, 0, i, "100%",self.rowHeight, {class:"ganttLinesSVG"});

                //creates links group
                self.linksGroup = svg.group("linksGroup");

                //creates tasks group
                self.tasksGroup = svg.group("tasksGroup");

                //compute scalefactor fx
                //self.fx = computedTableWidth / (endPeriod - startPeriod);
                self.fx = computedScaleX;

                // drawTodayLine
                if (new Date().getTime() > self.startMillis && new Date().getTime() < self.endMillis) {
                    var x = Math.round(((new Date().getTime()) - self.startMillis) * self.fx);
                    svg.line(gridGroup, x, 0, x, "100%", {class:"ganttTodaySVG"});
                }

            }
        });

        return box;
    }

    //if include today synch extremes
    if (this.includeToday) {
        var today = new Date().getTime();
        originalStartmillis = originalStartmillis > today ? today : originalStartmillis;
        originalEndMillis = originalEndMillis < today ? today : originalEndMillis;
    }

    //get best dimension fo gantt
    var period = getPeriod(zoom, originalStartmillis, originalEndMillis); //this is enlarged to match complete periods basing on zoom level

    //console.debug(new Date(period.start) + "   " + new Date(period.end));
    self.startMillis = period.start; //real dimension of gantt
    self.endMillis = period.end;
    self.originalStartMillis = originalStartmillis; //minimal dimension required by user or by task duration
    self.originalEndMillis = originalEndMillis;

    var table = createGantt(zoom, period.start, period.end);

    return table;
};


//<%-------------------------------------- GANT TASK GRAPHIC ELEMENT --------------------------------------%>
Ganttalendar.prototype.drawTask = function (task) {
    //console.debug("drawTask", task.name,new Date(task.start));
    var self = this;
    //var prof = new Profiler("ganttDrawTask");
    editorRow = task.rowElement;
    var top = editorRow.position().top + editorRow.offsetParent().scrollTop();

    //var normStart=Math.round(task.start/(3600000*24))*(3600000*24)
    //var normX = Math.round((normStart - self.startMillis) * self.fx);

    var x = Math.round((task.start - self.startMillis) * self.fx);

    //console.debug(x,normX)


    task.hasChild = task.isParent();

    var taskBox = $(_createTaskSVG(task, {x:x, y:top+self.taskVertOffset, width:Math.round((task.end - task.start) * self.fx),height:self.taskHeight}));
    task.ganttElement = taskBox;
    if (self.showCriticalPath && task.isCritical)
        taskBox.addClass("critical");

    if (this.master.permissions.canWrite && task.canWrite) {

        //bind all events on taskBox
        taskBox
            .click(function (e) { // manages selection
                e.stopPropagation();// to avoid body remove focused
                self.element.find("[class*=focused]").removeClass("focused");
                $(".ganttSVGBox .focused").removeClass("focused");
                var el = $(this);
                if (!self.resDrop)
                    el.addClass("focused");
                self.resDrop = false; //hack to avoid select

                $("body").off("click.focused").one("click.focused", function () {
                    $(".ganttSVGBox .focused").removeClass("focused");
                })

            }).dblclick(function () {
            self.master.showTaskEditor($(this).attr("taskid"));
        }).mouseenter(function () {
            //bring to top
            var el = $(this);
            if (!self.linkOnProgress) {
                el.find("[class*=linkHandleSVG]").show();
            } else {
                el.addClass("linkOver");
            }
        }).mouseleave(function () {
            var el = $(this);
            el.removeClass("linkOver").find("[class*=linkHandleSVG]").hide();

        }).mouseup(function (e) {
            $(":focus").blur(); // in order to save grid field when moving task
        }).mousedown(function () {
            var task = self.master.getTask($(this).attr("taskid"));
            task.rowElement.click();
        }).dragExtedSVG($(self.svg.root()), {
            canResize:  this.master.permissions.canWrite && task.canWrite,
            canDrag:    !task.depends && this.master.permissions.canWrite && task.canWrite,
            startDrag:  function (e) {
                $(".ganttSVGBox .focused").removeClass("focused");
            },
            drag:       function (e) {
                $("[from=" + task.id + "],[to=" + task.id + "]").trigger("update");
            },
            drop:       function (e) {
                self.resDrop = true; //hack to avoid select
                var taskbox = $(this);
                var task = self.master.getTask(taskbox.attr("taskid"));
                var s = Math.round((parseFloat(taskbox.attr("x")) / self.fx) + self.startMillis);
                self.master.beginTransaction();
                self.master.moveTask(task, new Date(s));
                self.master.endTransaction();
            },
            startResize:function (e) {
                //console.debug("startResize");
                $(".ganttSVGBox .focused").removeClass("focused");
                var taskbox = $(this);
                var text = $(self.svg.text(parseInt(taskbox.attr("x")) + parseInt(taskbox.attr("width") + 8), parseInt(taskbox.attr("y")), "", {"font-size":"10px", "fill":"red"}));
                taskBox.data("textDur", text);
            },
            resize:     function (e) {
                //find and update links from, to
                var taskbox = $(this);
                var st = Math.round((parseFloat(taskbox.attr("x")) / self.fx) + self.startMillis);
                var en = Math.round(((parseFloat(taskbox.attr("x")) + parseFloat(taskbox.attr("width"))) / self.fx) + self.startMillis);
                var d = computeStartDate(st).distanceInWorkingDays(computeEndDate(en))+1;
                var text = taskBox.data("textDur");
                text.attr("x", parseInt(taskbox.attr("x")) + parseInt(taskbox.attr("width")) + 8).html(d);

                $("[from=" + task.id + "],[to=" + task.id + "]").trigger("update");
            },
            stopResize: function (e) {
                self.resDrop = true; //hack to avoid select
                //console.debug(ui)
                var textBox = taskBox.data("textDur");
                if (textBox)
                    textBox.remove();
                var taskbox = $(this);
                var task = self.master.getTask(taskbox.attr("taskid"));
                var st = Math.round((parseFloat(taskbox.attr("x")) / self.fx) + self.startMillis);
                var en = Math.round(((parseFloat(taskbox.attr("x")) + parseFloat(taskbox.attr("width"))) / self.fx) + self.startMillis);
                self.master.beginTransaction();
                self.master.changeTaskDates(task, new Date(st), new Date(en));
                self.master.endTransaction();
            }
        });

        //binding for creating link
        taskBox.find("[class*=linkHandleSVG]").mousedown(function (e) {
            e.preventDefault();
            e.stopPropagation();
            var taskBox = $(this).closest(".taskBoxSVG");
            var svg = $(self.svg.root());
            var offs = svg.offset();
            self.linkOnProgress = true;
            self.linkFromEnd = $(this).is(".taskLinkEndSVG");
            svg.addClass("linkOnProgress");

            // create the line
            var startX = parseFloat(taskBox.attr("x")) + (self.linkFromEnd ? parseFloat(taskBox.attr("width")) : 0);
            var startY = parseFloat(taskBox.attr("y")) + parseFloat(taskBox.attr("height")) / 2;
            var line = self.svg.line(startX, startY, e.pageX - offs.left - 5, e.pageY - offs.top - 5, {class:"linkLineSVG"});
            var circle = self.svg.circle(startX, startY, 5, {class:"linkLineSVG"});

            //bind mousemove to draw a line
            svg.bind("mousemove.linkSVG", function (e) {
                var offs = svg.offset();
                var nx = e.pageX - offs.left;
                var ny = e.pageY - offs.top;
                var c = Math.sqrt(Math.pow(nx - startX, 2) + Math.pow(ny - startY, 2));
                nx = nx - (nx - startX) * 10 / c;
                ny = ny - (ny - startY) * 10 / c;
                self.svg.change(line, { x2:nx, y2:ny});
                self.svg.change(circle, { cx:nx, cy:ny});
            });

            //bind mouseup un body to stop
            $("body").one("mouseup.linkSVG", function (e) {
                $(line).remove();
                $(circle).remove();
                self.linkOnProgress = false;
                svg.removeClass("linkOnProgress");

                $(self.svg.root()).unbind("mousemove.linkSVG");
                var targetBox = $(e.target).closest(".taskBoxSVG");
                //console.debug("create link from " + taskBox.attr("taskid") + " to " + targetBox.attr("taskid"));

                if (targetBox && targetBox.attr("taskid") != taskBox.attr("taskid")) {
                    var taskTo;
                    var taskFrom;
                    if (self.linkFromEnd) {
                        taskTo = self.master.getTask(targetBox.attr("taskid"));
                        taskFrom = self.master.getTask(taskBox.attr("taskid"));
                    } else {
                        taskFrom = self.master.getTask(targetBox.attr("taskid"));
                        taskTo = self.master.getTask(taskBox.attr("taskid"));
                    }

                    if (taskTo && taskFrom) {
                        var gap = 0;
                        var depInp = taskTo.rowElement.find("[name=depends]");
                        depInp.val(depInp.val() + ((depInp.val() + "").length > 0 ? "," : "") + (taskFrom.getRow() + 1) + (gap != 0 ? ":" + gap : ""));
                        depInp.blur();
                    }
                }
            })
        });
    }
    //ask for redraw link
    self.redrawLinks();

    //prof.stop();


    function _createTaskSVG(task, dimensions) {
        var svg = self.svg;
        var taskSvg = svg.svg(self.tasksGroup, dimensions.x, dimensions.y, dimensions.width, dimensions.height, {class:"taskBox taskBoxSVG taskStatusSVG", status:task.status, taskid:task.id });

        //svg.title(taskSvg, task.name);
        //external box
        var layout = svg.rect(taskSvg, 0, 0, "100%", "100%", {class:"taskLayout", rx:"2", ry:"2"});

        //svg.rect(taskSvg, 0, 0, "100%", "100%", {fill:"rgba(255,255,255,.3)"});

        //external dep
        if (task.hasExternalDep)
            svg.rect(taskSvg, 0, 0, "100%", "100%", {fill:"url(#extDep)"});

        //progress
        if (task.progress > 0) {
            var progress = svg.rect(taskSvg, 0, "20%", (task.progress > 100 ? 100 : task.progress) + "%", "60%", {rx:"2", ry:"2",fill:"rgba(0,0,0,.4)"});
            if (dimensions.width > 50) {
                var textStyle = {fill:"#888", "font-size":"10px",class:"textPerc teamworkIcons",transform:"translate(5)"};
                if (task.progress > 100)
                    textStyle["font-weight"]="bold";
                if (task.progress > 90)
                    textStyle.transform = "translate(-40)";
                svg.text(taskSvg, (task.progress > 90 ? 100 : task.progress) + "%", (self.rowHeight-5)/2, (task.progress>100?"!!! ":"")+ task.progress + "%", textStyle);
            }
        }

        if (task.hasChild)
            svg.rect(taskSvg, 0, 0, "100%", 3, {fill:"#000"});

        if (task.startIsMilestone) {
            svg.image(taskSvg, -9, dimensions.height/2-9, 18, 18, self.master.resourceUrl +"milestone.png")
        }

        if (task.endIsMilestone) {
            svg.image(taskSvg, "100%",dimensions.height/2-9, 18, 18, self.master.resourceUrl +"milestone.png", {transform:"translate(-9)"})
        }

        //task label
        svg.text(taskSvg, "100%", 18, task.name, {class:"taskLabelSVG", transform:"translate(20,-5)"});

        //link tool
        if (task.level>0){
            svg.circle(taskSvg, "0",  dimensions.height/2,dimensions.height/3, {class:"taskLinkStartSVG linkHandleSVG", transform:"translate("+(-dimensions.height/3+1)+")"});
            svg.circle(taskSvg, "100%",dimensions.height/2,dimensions.height/3, {class:"taskLinkEndSVG linkHandleSVG", transform:"translate("+(dimensions.height/3-1)+")"});
        }
        return taskSvg
    }

};


Ganttalendar.prototype.addTask = function (task) {
    //set new boundaries for gantt
    this.originalEndMillis = this.originalEndMillis > task.end ? this.originalEndMillis : task.end;
    this.originalStartMillis = this.originalStartMillis < task.start ? this.originalStartMillis : task.start;
};


//<%-------------------------------------- GANT DRAW LINK SVG ELEMENT --------------------------------------%>
//'from' and 'to' are tasks already drawn
Ganttalendar.prototype.drawLink = function (from, to, type) {
    var self = this;
    //console.debug("drawLink")
    var peduncolusSize = 10;

    /**
     * Given an item, extract its rendered position
     * width and height into a structure.
     */
    function buildRect(item) {
        var p = item.ganttElement.position();
        var rect = {
            left:  parseFloat(item.ganttElement.attr("x")),
            top:   parseFloat(item.ganttElement.attr("y")),
            width: parseFloat(item.ganttElement.attr("width")),
            height:parseFloat(item.ganttElement.attr("height"))
        };
        return rect;
    }

    /**
     * The default rendering method, which paints a start to end dependency.
     */
    function drawStartToEnd(from, to, ps) {
        var svg = self.svg;

        //this function update an existing link
        function update() {
            var group = $(this);
            var from = group.data("from");
            var to = group.data("to");

            var rectFrom = buildRect(from);
            var rectTo = buildRect(to);

            var fx1 = rectFrom.left;
            var fx2 = rectFrom.left + rectFrom.width;
            var fy = rectFrom.height / 2 + rectFrom.top;

            var tx1 = rectTo.left;
            var tx2 = rectTo.left + rectTo.width;
            var ty = rectTo.height / 2 + rectTo.top;


            var tooClose = tx1 < fx2 + 2 * ps;
            var r = 5; //radius
            var arrowOffset = 5;
            var up = fy > ty;
            var fup = up ? -1 : 1;

            var prev = fx2 + 2 * ps > tx1;
            var fprev = prev ? -1 : 1;

            var image = group.find("image");
            var p = svg.createPath();

            if (tooClose) {
                var firstLine = fup * (rectFrom.height / 2 - 2 * r + 2);
                p.move(fx2, fy)
                    .line(ps, 0, true)
                    .arc(r, r, 90, false, !up, r, fup * r, true)
                    .line(0, firstLine, true)
                    .arc(r, r, 90, false, !up, -r, fup * r, true)
                    .line(fprev * 2 * ps + (tx1 - fx2), 0, true)
                    .arc(r, r, 90, false, up, -r, fup * r, true)
                    .line(0, (Math.abs(ty - fy) - 4 * r - Math.abs(firstLine)) * fup - arrowOffset, true)
                    .arc(r, r, 90, false, up, r, fup * r, true)
                    .line(ps, 0, true);
                image.attr({x:tx1 - 5, y:ty - 5 - arrowOffset});

            } else {
                p.move(fx2, fy)
                    .line((tx1 - fx2) / 2 - r, 0, true)
                    .arc(r, r, 90, false, !up, r, fup * r, true)
                    .line(0, ty - fy - fup * 2 * r + arrowOffset, true)
                    .arc(r, r, 90, false, up, r, fup * r, true)
                    .line((tx1 - fx2) / 2 - r, 0, true);
                image.attr({x:tx1 - 5, y:ty - 5 + arrowOffset});
            }

            group.find("path").attr({d:p.path()});
        }


        // create the group
        var group = svg.group(self.linksGroup, "" + from.id + "-" + to.id);
        svg.title(group, from.name + " -> " + to.name);

        var p = svg.createPath();

        //add the arrow
        svg.image(group, 0, 0, 5, 10, self.master.resourceUrl +"linkArrow.png");
        //create empty path
        svg.path(group, p, {class:"taskLinkPathSVG"});

        //set "from" and "to" to the group, bind "update" and trigger it
        var jqGroup = $(group).data({from:from, to:to }).attr({from:from.id, to:to.id}).on("update", update).trigger("update");

        if (self.showCriticalPath && from.isCritical && to.isCritical)
            jqGroup.addClass("critical");

        jqGroup.addClass("linkGroup");
        return jqGroup;
    }


    /**
     * A rendering method which paints a start to start dependency.
     */
    function drawStartToStart(from, to) {
        console.error("StartToStart not supported on SVG");
        var rectFrom = buildRect(from);
        var rectTo = buildRect(to);
    }

    var link;
    // Dispatch to the correct renderer
    if (type == 'start-to-start') {
        link = drawStartToStart(from, to, peduncolusSize);
    } else {
        link = drawStartToEnd(from, to, peduncolusSize);
    }

    if (this.master.permissions.canWrite && (from.canWrite || to.canWrite)) {
        link.click(function (e) {
            var el = $(this);
            e.stopPropagation();// to avoid body remove focused
            self.element.find("[class*=focused]").removeClass("focused");
            $(".ganttSVGBox .focused").removeClass("focused");
            var el = $(this);
            if (!self.resDrop)
                el.addClass("focused");
            self.resDrop = false; //hack to avoid select

            $("body").off("click.focused").one("click.focused", function () {
                $(".ganttSVGBox .focused").removeClass("focused");
            })

        });
    }


};

Ganttalendar.prototype.redrawLinks = function () {
    //console.debug("redrawLinks ");
    var self = this;
    this.element.stopTime("ganttlnksredr");
    this.element.oneTime(60, "ganttlnksredr", function () {

        //var prof=new Profiler("gd_drawLink_real");

        //remove all links
        $("#linksSVG").empty();

        var collapsedDescendant = [];

        //[expand]
        var collapsedDescendant = self.master.getCollapsedDescendant();
        for (var i = 0; i < self.master.links.length; i++) {
            var link = self.master.links[i];

            if (collapsedDescendant.indexOf(link.from) >= 0 || collapsedDescendant.indexOf(link.to) >= 0) continue;

            self.drawLink(link.from, link.to);
        }
        //prof.stop();
    });
};


Ganttalendar.prototype.reset = function () {
    this.element.find("[class*=linkGroup]").remove();
    this.element.find("[taskid]").remove();
};


Ganttalendar.prototype.redrawTasks = function () {
    //[expand]
    var collapsedDescendant = this.master.getCollapsedDescendant();
    for (var i = 0; i < this.master.tasks.length; i++) {
        var task = this.master.tasks[i];
        if (collapsedDescendant.indexOf(task) >= 0) continue;
        this.drawTask(task);
    }
};


Ganttalendar.prototype.refreshGantt = function () {
    //console.debug("refreshGantt")

    if (this.showCriticalPath) {
        this.master.computeCriticalPath();
    }


    var par = this.element.parent();

    //try to maintain last scroll
    var scrollY = par.scrollTop();
    var scrollX = par.scrollLeft();

    this.element.remove();
    //guess the zoom level in base of period
    if (!this.zoom) {
        var days = Math.round((this.originalEndMillis - this.originalStartMillis) / (3600000 * 24));
        //"d", "w","w2","w3", "m","m2", "q", "s", "y"
        this.zoom = this.zoomLevels[days < 2 ? 0 : (days < 15 ? 1 : (days < 30 ? 2 : (days < 45 ? 3 : (days < 60 ? 4 : (days < 90 ? 5 : (days < 180 ? 6 : (days < 600 ? 7 : 8  )  )  )  ) ) ) )];
    }
    var domEl = this.create(this.zoom, this.originalStartMillis, this.originalEndMillis);
    this.element = domEl;
    par.append(domEl);
    this.redrawTasks();

    //set old scroll
    //console.debug("old scroll:",scrollX,scrollY)
    par.scrollTop(scrollY);
    par.scrollLeft(scrollX);

    //set current task
    this.synchHighlight();

};


Ganttalendar.prototype.fitGantt = function () {
    delete this.zoom;
    this.refreshGantt();
};

Ganttalendar.prototype.synchHighlight = function () {
    //console.debug("synchHighlight",this.master.currentTask);
    if (this.master.currentTask ){
        // take care of collapsed rows
        var ganttHighLighterPosition=this.master.editor.element.find(".taskEditRow:visible").index(this.master.currentTask.rowElement);
        this.master.gantt.element.find(".ganttLinesSVG").removeClass("rowSelected").eq(ganttHighLighterPosition).addClass("rowSelected");
    } else {
        $(".rowSelected").removeClass("rowSelected"); // todo non c'era
    }


};


Ganttalendar.prototype.getCenterMillis= function () {
    return parseInt((this.element.parent().scrollLeft()+this.element.parent().width()/2)/this.fx+this.startMillis);
};

Ganttalendar.prototype.goToMillis= function (millis) {
    var x = Math.round(((millis) - this.startMillis) * this.fx) -this.element.parent().width()/2;
    this.element.parent().scrollLeft(x);
};

Ganttalendar.prototype.centerOnToday = function () {
    this.goToMillis(new Date().getTime());



};


/**
 * Allows drag and drop and extesion of task boxes. Only works on x axis
 * @param opt
 * @return {*}
 */
$.fn.dragExtedSVG = function (svg, opt) {

    //doing this can work with one svg at once only
    var target;
    var svgX;
    var offsetMouseRect;

    var options = {
        canDrag:        true,
        canResize:      true,
        resizeZoneWidth:10,
        minSize:        10,
        startDrag:      function (e) {},
        drag:           function (e) {},
        drop:           function (e) {},
        startResize:    function (e) {},
        resize:         function (e) {},
        stopResize:     function (e) {}
    };

    $.extend(options, opt);

    this.each(function () {
        var el = $(this);
        svgX = svg.parent().offset().left; //parent is used instead of svg for a Firefox oddity
        if (options.canDrag)
            el.addClass("deSVGdrag");

        if (options.canResize || options.canDrag) {
            el.bind("mousedown.deSVG",function (e) {
                    //console.debug("mousedown.deSVG");
                    if ($(e.target).is("image")) {
                        e.preventDefault();
                    }

                    target = $(this);
                    var x1 = parseFloat(el.find("[class*=taskLayout]").offset().left);
                    var x2 = x1 + parseFloat(el.attr("width"));
                    var posx = e.pageX;

                    $("body").unselectable();

                    //start resize end
                    if (options.canResize && (x2-x1)>3*options.resizeZoneWidth && (posx<=x2 &&  posx >= x2- options.resizeZoneWidth)) {
                        //store offset mouse x2
                        offsetMouseRect = x2 - e.pageX;
                        target.attr("oldw", target.attr("width"));

                        var one = true;

                        //bind event for start resizing
                        $(svg).bind("mousemove.deSVG", function (e) {

                            if (one) {
                                //trigger startResize
                                options.startResize.call(target.get(0), e);
                                one = false;
                            }

                            //manage resizing
                            var nW =  e.pageX - x1 + offsetMouseRect;

                            target.attr("width", nW < options.minSize ? options.minSize : nW);
                            //callback
                            options.resize.call(target.get(0), e);
                        });

                        //bind mouse up on body to stop resizing
                        $("body").one("mouseup.deSVG", stopResize);


                        //start resize start
                    } else  if (options.canResize && (x2-x1)>3*options.resizeZoneWidth && (posx>=x1 && posx<=x1+options.resizeZoneWidth)) {
                        //store offset mouse x1
                        offsetMouseRect = parseFloat(target.attr("x"));
                        target.attr("oldw", target.attr("width")); //todo controllare se è ancora usato oldw

                        var one = true;

                        //bind event for start resizing
                        $(svg).bind("mousemove.deSVG", function (e) {

                            if (one) {
                                //trigger startResize
                                options.startResize.call(target.get(0), e);
                                one = false;
                            }

                            //manage resizing
                            var nx1= offsetMouseRect-(posx-e.pageX);
                            var nW = (x2-x1) + (posx-e.pageX);
                            nW=nW < options.minSize ? options.minSize : nW;
                            target.attr("x",nx1);
                            target.attr("width", nW);
                            //callback
                            options.resize.call(target.get(0), e);
                        });

                        //bind mouse up on body to stop resizing
                        $("body").one("mouseup.deSVG", stopResize);



                        // start drag
                    } else if (options.canDrag) {
                        //store offset mouse x1
                        offsetMouseRect = parseFloat(target.attr("x")) - e.pageX;
                        target.attr("oldx", target.attr("x"));

                        var one = true;
                        //bind event for start dragging
                        $(svg).bind("mousemove.deSVG",function (e) {
                            if (one) {
                                //trigger startDrag
                                options.startDrag.call(target.get(0), e);
                                one = false;
                            }

                            //manage resizing
                            target.attr("x", offsetMouseRect + e.pageX);
                            //callback
                            options.drag.call(target.get(0), e);

                        }).bind("mouseleave.deSVG", drop);

                        //bind mouse up on body to stop resizing
                        $("body").one("mouseup.deSVG", drop);

                    }
                }

            ).bind("mousemove.deSVG",
                function (e) {
                    var el = $(this);
                    var x1 = el.find("[class*=taskLayout]").offset().left;
                    var x2 = x1 + parseFloat(el.attr("width"));
                    var posx = e.pageX;

                    //set cursor handle
                    if (options.canResize && (x2-x1)>3*options.resizeZoneWidth &&((posx<=x2 &&  posx >= x2- options.resizeZoneWidth) || (posx>=x1 && posx<=x1+options.resizeZoneWidth))) {
                        el.addClass("deSVGhand");
                    } else {
                        el.removeClass("deSVGhand");
                    }
                }

            ).addClass("deSVG");
        }
    });
    return this;


    function stopResize(e) {
        $(svg).unbind("mousemove.deSVG").unbind("mouseup.deSVG").unbind("mouseleave.deSVG");
        if (target && target.attr("oldw")!=target.attr("width"))
            options.stopResize.call(target.get(0), e); //callback
        target = undefined;
        $("body").clearUnselectable();
    }

    function drop(e) {
        $(svg).unbind("mousemove.deSVG").unbind("mouseup.deSVG").unbind("mouseleave.deSVG");
        if (target && target.attr("oldx") != target.attr("x"))
            options.drop.call(target.get(0), e); //callback
        target = undefined;
        $("body").clearUnselectable();
    }

};



/*
 Copyright (c) 2012-2017 Open Lab
 Written by Roberto Bicchierai and Silvia Chelazzi http://roberto.open-lab.com
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
function GridEditor(master) {
    this.master = master; // is the a GantEditor instance

    var editorTabel = $.JST.createFromTemplate({}, "TASKSEDITHEAD");
    if (!master.permissions.canSeeDep)
        editorTabel.find(".requireCanSeeDep").hide();

    this.gridified = $.gridify(editorTabel);

    this.element = this.gridified.find(".gdfTable").eq(1);
}


GridEditor.prototype.fillEmptyLines = function () {
    //console.debug("fillEmptyLines")
    var factory = new TaskFactory();
    var master = this.master;

    //console.debug("GridEditor.fillEmptyLines");
    var rowsToAdd = master.minRowsInEditor - this.element.find(".taskEditRow").length;
    var empty=this.element.find(".emptyRow").length;
    rowsToAdd=Math.max(rowsToAdd,empty>5?0:5-empty);

    //fill with empty lines
    for (var i = 0; i < rowsToAdd; i++) {
        var emptyRow = $.JST.createFromTemplate({}, "TASKEMPTYROW");
        if (!master.permissions.canSeeDep)
            emptyRow.find(".requireCanSeeDep").hide();

        //click on empty row create a task and fill above
        emptyRow.click(function (ev) {
            //console.debug("emptyRow.click")
            var emptyRow = $(this);
            //add on the first empty row only
            if (!master.permissions.canWrite || !master.permissions.canAdd || emptyRow.prevAll(".emptyRow").length > 0)
                return;

            master.beginTransaction();
            var lastTask;
            var start = new Date().getTime();
            var level = 0;
            if (master.tasks[0]) {
                start = master.tasks[0].start;
                level = master.tasks[0].level + 1;
            }

            //fill all empty previouses
            var cnt=0;
            emptyRow.prevAll(".emptyRow").addBack().each(function () {
                cnt++;
                var ch = factory.build("tmp_fk" + new Date().getTime()+"_"+cnt, "", "", level, start, 1);
                var task = master.addTask(ch);
                lastTask = ch;
            });
            master.endTransaction();
            if (lastTask.rowElement) {
                //lastTask.rowElement.click();  removed R&S 22/03/2016 il click è bindato comunque
                lastTask.rowElement.find("[name=name]").focus();//focus to "name" input
            }
        });
        this.element.append(emptyRow);
    }
};


GridEditor.prototype.addTask = function (task, row, hideIfParentCollapsed) {
    //console.debug("GridEditor.addTask",task,row);
    //var prof = new Profiler("editorAddTaskHtml");

    //remove extisting row
    this.element.find("[taskId=" + task.id + "]").remove();

    var taskRow = $.JST.createFromTemplate(task, "TASKROW");

    if (!this.master.permissions.canSeeDep)
        taskRow.find(".requireCanSeeDep").hide();

    if (!this.master.permissions.canSeePopEdit)
        taskRow.find(".edit .teamworkIcon").hide();

    //save row element on task
    task.rowElement = taskRow;

    this.bindRowEvents(task, taskRow);

    if (typeof(row) != "number") {
        var emptyRow = this.element.find(".emptyRow:first"); //tries to fill an empty row
        if (emptyRow.length > 0)
            emptyRow.replaceWith(taskRow);
        else
            this.element.append(taskRow);
    } else {
        var tr = this.element.find("tr.taskEditRow").eq(row);
        if (tr.length > 0) {
            tr.before(taskRow);
        } else {
            this.element.append(taskRow);
        }

    }

    //[expand]
    if (hideIfParentCollapsed) {
        if (task.collapsed) taskRow.addClass('collapsed');
        var collapsedDescendant = this.master.getCollapsedDescendant();
        if (collapsedDescendant.indexOf(task) >= 0) taskRow.hide();
    }

    return taskRow;
};

GridEditor.prototype.refreshExpandStatus = function (task) {
    //console.debug("refreshExpandStatus",task);
    if (!task) return;
    if (task.isParent()) {
        task.rowElement.addClass("isParent");
    } else {
        task.rowElement.removeClass("isParent");
    }

    var par = task.getParent();
    if (par && !par.rowElement.is("isParent")) {
        par.rowElement.addClass("isParent");
    }

};

GridEditor.prototype.refreshTaskRow = function (task) {
    //console.debug("refreshTaskRow")
    //var profiler = new Profiler("editorRefreshTaskRow");
    var row = task.rowElement;

    row.find(".taskRowIndex").html(task.getRow() + 1);
    row.find(".indentCell").css("padding-left", task.level * 10 + 18);
    row.find("[name=name]").val(task.name);
    row.find("[name=code]").val(task.code);
    row.find("[status]").attr("status", task.status);

    row.find("[name=duration]").val(task.duration);
    row.find("[name=progress]").val(task.progress).prop("readonly",task.progressByWorklog==true);
    row.find("[name=startIsMilestone]").prop("checked", task.startIsMilestone);
    row.find("[name=start]").val(new Date(task.start).format()).updateOldValue().prop("readonly",task.depends || !task.canWrite  && !this.master.permissions.canWrite ); // called on dates only because for other field is called on focus event
    row.find("[name=endIsMilestone]").prop("checked", task.endIsMilestone);
    row.find("[name=end]").val(new Date(task.end).format()).updateOldValue();
    row.find("[name=depends]").val(task.depends);
    row.find(".taskAssigs").html(task.getAssigsString());

    //manage collapsed
    if (task.collapsed)
        row.addClass("collapsed");
    else
        row.removeClass("collapsed");


    //Enhancing the function to perform own operations
    this.master.element.trigger('gantt.task.afterupdate.event', task);
    //profiler.stop();
};

GridEditor.prototype.redraw = function () {
    //console.debug("GridEditor.prototype.redraw")
    for (var i = 0; i < this.master.tasks.length; i++) {
        this.refreshTaskRow(this.master.tasks[i]);
    }
    // check if new emty rows are needed
    if (this.master.fillWithEmptyLines)
        this.fillEmptyLines();

    //

};

GridEditor.prototype.reset = function () {
    this.element.find("[taskid]").remove();
};


GridEditor.prototype.bindRowEvents = function (task, taskRow) {
    var self = this;
    //console.debug("bindRowEvents",this,this.master,this.master.permissions.canWrite, task.canWrite);
    if (this.master.permissions.canWrite && task.canWrite) {
        self.bindRowInputEvents(task, taskRow);

    } else { //cannot write: disable input
        taskRow.find("input").prop("readonly", true);
        taskRow.find("input:checkbox,select").prop("disabled", true);
    }

    if (!this.master.permissions.canSeeDep)
        taskRow.find("[name=depends]").attr("readonly", true);

    self.bindRowExpandEvents(task, taskRow);
    if (this.master.permissions.canSeePopEdit) {
        taskRow.find(".edit").click(function () {self.openFullEditor(task, taskRow, false)});
        taskRow.find(".taskAssigs").dblclick(function () {self.openFullEditor(task, taskRow, true)});
    }
};


GridEditor.prototype.bindRowExpandEvents = function (task, taskRow) {
    var self = this;
    //expand collapse
    taskRow.find(".exp-controller").click(function () {
        var el = $(this);
        var taskId = el.closest("[taskid]").attr("taskid");
        var task = self.master.getTask(taskId);
        if (task.collapsed) {
            self.master.expand(task,false);
        } else {
            self.master.collapse(task,false);
        }
    });
};

GridEditor.prototype.bindRowInputEvents = function (task, taskRow) {
    var self = this;

    //bind dateField on dates
    taskRow.find(".date").each(function () {
        var el = $(this);
        el.click(function () {
            var inp = $(this);
            inp.dateField({
                inputField: el,
                callback:   function (d) {
                    $(this).blur();
                }
            });
        });

        el.blur(function (date) {
            var inp = $(this);
            if (inp.isValueChanged()) {
                if (!Date.isValid(inp.val())) {
                    alert(GanttMaster.messages["INVALID_DATE_FORMAT"]);
                    inp.val(inp.getOldValue());

                } else {
                    var row = inp.closest("tr");
                    var taskId = row.attr("taskId");
                    var task = self.master.getTask(taskId);

                    var leavingField = inp.prop("name");
                    var dates = resynchDates(inp, row.find("[name=start]"), row.find("[name=startIsMilestone]"), row.find("[name=duration]"), row.find("[name=end]"), row.find("[name=endIsMilestone]"));
                    //console.debug("resynchDates",new Date(dates.start), new Date(dates.end),dates.duration)
                    //update task from editor
                    self.master.beginTransaction();
                    self.master.changeTaskDates(task, dates.start, dates.end);
                    self.master.endTransaction();
                    inp.updateOldValue(); //in order to avoid multiple call if nothing changed
                }
            }
        });
    });


    //milestones checkbox
    taskRow.find(":checkbox").click(function () {
        var el = $(this);
        var row = el.closest("tr");
        var taskId = row.attr("taskId");

        var task = self.master.getTask(taskId);

        //update task from editor
        var field = el.prop("name");

        if (field == "startIsMilestone" || field == "endIsMilestone") {
            self.master.beginTransaction();
            //milestones
            task[field] = el.prop("checked");
            resynchDates(el, row.find("[name=start]"), row.find("[name=startIsMilestone]"), row.find("[name=duration]"), row.find("[name=end]"), row.find("[name=endIsMilestone]"));
            self.master.endTransaction();
        }

    });


    //binding on blur for task update (date exluded as click on calendar blur and then focus, so will always return false, its called refreshing the task row)
    taskRow.find("input:text:not(.date)").focus(function () {
        $(this).updateOldValue();

    }).blur(function (event) {
        var el = $(this);
        var row = el.closest("tr");
        var taskId = row.attr("taskId");
        var task = self.master.getTask(taskId);
        //update task from editor
        var field = el.prop("name");
        //console.debug("blur",field)

        if (el.isValueChanged()) {
            self.master.beginTransaction();

            if (field == "depends") {

                var oldDeps = task.depends;
                task.depends = el.val();


                // update links
                var linkOK = self.master.updateLinks(task);
                if (linkOK) {
                    //synchronize status from superiors states
                    var sups = task.getSuperiors();


                    /*
                     for (var i = 0; i < sups.length; i++) {
                     if (!sups[i].from.synchronizeStatus())
                     break;
                     }
                     */

                    var oneFailed=false;
                    var oneUndefined=false;
                    var oneActive=false;
                    var oneSuspended=false;
                    for (var i = 0; i < sups.length; i++) {
                        oneFailed=oneFailed|| sups[i].from.status=="STATUS_FAILED";
                        oneUndefined=oneUndefined|| sups[i].from.status=="STATUS_UNDEFINED";
                        oneActive=oneActive|| sups[i].from.status=="STATUS_ACTIVE";
                        oneSuspended=oneSuspended|| sups[i].from.status=="STATUS_SUSPENDED";
                    }

                    if (oneFailed){
                        task.changeStatus("STATUS_FAILED")
                    } else if (oneUndefined){
                        task.changeStatus("STATUS_UNDEFINED")
                    } else if (oneActive){
                        task.changeStatus("STATUS_SUSPENDED")
                    } else  if (oneSuspended){
                        task.changeStatus("STATUS_SUSPENDED")
                    } else {
                        task.changeStatus("STATUS_ACTIVE")
                    }


                    self.master.changeTaskDeps(task); //dates recomputation from dependencies
                }

            } else if (field == "duration") {
                var dates = resynchDates(el, row.find("[name=start]"), row.find("[name=startIsMilestone]"), row.find("[name=duration]"), row.find("[name=end]"), row.find("[name=endIsMilestone]"));
                self.master.changeTaskDates(task, dates.start, dates.end);

            } else if (field == "name" && el.val() == "") { // remove unfilled task
                task.deleteTask();
                self.master.gantt.synchHighlight();


            } else if (field == "progress" ) {
                task[field]=parseFloat(el.val())||0;
                el.val(task[field]);

            } else {
                task[field] = el.val();
            }
            self.master.endTransaction();

        } else if (field == "name" && el.val() == "") { // remove unfilled task even if not changed
            if (task.getRow()!=0) {
                task.deleteTask();
                self.master.gantt.synchHighlight();
            }else {
                el.oneTime(1,"foc",function(){$(this).focus()}); //
                event.preventDefault();
                //return false;
            }

        }
    });

    //cursor key movement
    taskRow.find("input").keydown(function (event) {
        var theCell = $(this);
        var theTd = theCell.parent();
        var theRow = theTd.parent();
        var col = theTd.prevAll("td").length;

        var ret = true;
        if (!event.ctrlKey) {
            switch (event.keyCode) {

                case 37: //left arrow
                    if (!theCell.is(":text") || (!this.selectionEnd || this.selectionEnd == 0))
                        theTd.prev().find("input").focus();
                    break;
                case 39: //right arrow
                    if (!theCell.is(":text") || (!this.selectionEnd || this.selectionEnd == this.value.length))
                        theTd.next().find("input").focus();
                    break;

                case 38: //up arrow
                    //var prevRow = theRow.prev();
                    var prevRow = theRow.prevAll(":visible:first");
                    var td = prevRow.find("td").eq(col);
                    var inp = td.find("input");

                    if (inp.length > 0)
                        inp.focus();
                    break;
                case 40: //down arrow
                    //var nextRow = theRow.next();
                    var nextRow = theRow.nextAll(":visible:first");
                    var td = nextRow.find("td").eq(col);
                    var inp = td.find("input");
                    if (inp.length > 0)
                        inp.focus();
                    else
                        nextRow.click(); //create a new row
                    break;
                case 36: //home
                    break;
                case 35: //end
                    break;

                case 9: //tab
                case 13: //enter
                    break;
            }
        }
        return ret;

    }).focus(function () {
        $(this).closest("tr").click();
    });


    //change status
    taskRow.find(".taskStatus").click(function () {
        var el = $(this);
        var tr = el.closest("[taskid]");
        var taskId = tr.attr("taskid");
        var task = self.master.getTask(taskId);

        var changer = $.JST.createFromTemplate({}, "CHANGE_STATUS");
        changer.find("[status=" + task.status + "]").addClass("selected");
        changer.find(".taskStatus").click(function (e) {
            e.stopPropagation();
            var newStatus = $(this).attr("status");
            changer.remove();
            self.master.beginTransaction();
            task.changeStatus(newStatus);
            self.master.endTransaction();
            el.attr("status", task.status);
        });
        el.oneTime(3000, "hideChanger", function () {
            changer.remove();
        });
        el.after(changer);
    });


    //bind row selection
    taskRow.click(function (event) {
        var row = $(this);
        //console.debug("taskRow.click",row.attr("taskid"),event.target)
        //var isSel = row.hasClass("rowSelected");
        row.closest("table").find(".rowSelected").removeClass("rowSelected");
        row.addClass("rowSelected");

        //set current task
        self.master.currentTask = self.master.getTask(row.attr("taskId"));

        //move highlighter
        self.master.gantt.synchHighlight();

        //if offscreen scroll to element
        var top = row.position().top;
        if (top > self.element.parent().height()) {
            row.offsetParent().scrollTop(top - self.element.parent().height() + 100);
        } else if (top <= 40) {
            row.offsetParent().scrollTop(row.offsetParent().scrollTop() - 40 + top);
        }
    });

};


GridEditor.prototype.openFullEditor = function (task, taskRow, editOnlyAssig) {
    var self = this;

    if (!self.master.permissions.canSeePopEdit)
        return;

    //task editor in popup
    var taskId = taskRow.attr("taskId");
    //console.debug(task);

    //make task editor
    var taskEditor = $.JST.createFromTemplate(task, "TASK_EDITOR");

    //hide task data if editing assig only
    if (editOnlyAssig) {
        taskEditor.find(".taskData").hide();
        taskEditor.find(".assigsTableWrapper").height(455);
        taskEditor.prepend("<h1>\""+task.name+"\"</h1>");
    }

    //got to extended editor
    if (task.isNew()|| !self.master.permissions.canSeeFullEdit){
        taskEditor.find("#taskFullEditor").remove();
    } else {
        taskEditor.bind("openFullEditor.gantt",function () {
            window.location.href=contextPath+"/applications/teamwork/task/taskEditor.jsp?CM=ED&OBJID="+task.id;
        });
    }


    taskEditor.find("#name").val(task.name);
    taskEditor.find("#description").val(task.description);
    taskEditor.find("#code").val(task.code);
    taskEditor.find("#progress").val(task.progress ? parseFloat(task.progress) : 0).prop("readonly",task.progressByWorklog==true);
    taskEditor.find("#progressByWorklog").prop("checked",task.progressByWorklog);
    taskEditor.find("#status").val(task.status);
    taskEditor.find("#type").val(task.typeId);
    taskEditor.find("#type_txt").val(task.type);
    taskEditor.find("#relevance").val(task.relevance);
    //cvc_redraw(taskEditor.find(".cvcComponent"));


    if (task.startIsMilestone)
        taskEditor.find("#startIsMilestone").prop("checked", true);
    if (task.endIsMilestone)
        taskEditor.find("#endIsMilestone").prop("checked", true);

    taskEditor.find("#duration").val(task.duration);
    var startDate = taskEditor.find("#start");
    startDate.val(new Date(task.start).format());
    //start is readonly in case of deps
    if (task.depends || !this.master.permissions.canWrite && !task.canWrite) {
        startDate.attr("readonly", "true");
    } else {
        startDate.removeAttr("readonly");
    }

    taskEditor.find("#end").val(new Date(task.end).format());

    //make assignments table
    var assigsTable = taskEditor.find("#assigsTable");
    assigsTable.find("[assId]").remove();
    // loop on assignments
    for (var i = 0; i < task.assigs.length; i++) {
        var assig = task.assigs[i];
        var assigRow = $.JST.createFromTemplate({task: task, assig: assig}, "ASSIGNMENT_ROW");
        assigsTable.append(assigRow);
    }

    if (!self.master.permissions.canWrite || !task.canWrite) {
        taskEditor.find("input,textarea").prop("readOnly", true);
        taskEditor.find("input:checkbox,select").prop("disabled", true);
        taskEditor.find("#saveButton").remove();
        taskEditor.find(".button").addClass("disabled");

    } else {

        //bind dateField on dates, duration
        taskEditor.find("#start,#end,#duration").click(function () {
            var input = $(this);
            if (input.is("[entrytype=DATE]")) {
                input.dateField({
                    inputField: input,
                    callback:   function (d) {$(this).blur();}
                });
            }
        }).blur(function () {
            var inp = $(this);
            if (inp.validateField()) {
                resynchDates(inp, taskEditor.find("[name=start]"), taskEditor.find("[name=startIsMilestone]"), taskEditor.find("[name=duration]"), taskEditor.find("[name=end]"), taskEditor.find("[name=endIsMilestone]"));
                //workload computation
                if (typeof(workloadDatesChanged)=="function")
                    workloadDatesChanged();
            }
        });

        taskEditor.find("#startIsMilestone,#endIsMilestone").click(function () {
            var inp = $(this);
            resynchDates(inp, taskEditor.find("[name=start]"), taskEditor.find("[name=startIsMilestone]"), taskEditor.find("[name=duration]"), taskEditor.find("[name=end]"), taskEditor.find("[name=endIsMilestone]"));
        });

        //bind add assignment
        var cnt=0;
        taskEditor.find("#addAssig").click(function () {
            cnt++;
            var assigsTable = taskEditor.find("#assigsTable");
            var assigRow = $.JST.createFromTemplate({task: task, assig: {id: "tmp_" + new Date().getTime()+"_"+cnt}}, "ASSIGNMENT_ROW");
            assigsTable.append(assigRow);
            $("#bwinPopupd").scrollTop(10000);
        }).click();

        //save task
        taskEditor.bind("saveFullEditor.gantt",function () {
            //console.debug("saveFullEditor");
            var task = self.master.getTask(taskId); // get task again because in case of rollback old task is lost

            self.master.beginTransaction();
            task.name = taskEditor.find("#name").val();
            task.description = taskEditor.find("#description").val();
            task.code = taskEditor.find("#code").val();
            task.progress = parseFloat(taskEditor.find("#progress").val());
            //task.duration = parseInt(taskEditor.find("#duration").val()); //bicch rimosso perchè devono essere ricalcolata dalla start end, altrimenti sbaglia
            task.startIsMilestone = taskEditor.find("#startIsMilestone").is(":checked");
            task.endIsMilestone = taskEditor.find("#endIsMilestone").is(":checked");

            task.type = taskEditor.find("#type_txt").val();
            task.typeId = taskEditor.find("#type").val();
            task.relevance = taskEditor.find("#relevance").val();
            task.progressByWorklog= taskEditor.find("#progressByWorklog").is(":checked");

            //set assignments
            var cnt=0;
            taskEditor.find("tr[assId]").each(function () {
                var trAss = $(this);
                var assId = trAss.attr("assId");
                var resId = trAss.find("[name=resourceId]").val();
                var resName = trAss.find("[name=resourceId_txt]").val(); // from smartcombo text input part
                var roleId = trAss.find("[name=roleId]").val();
                var effort = millisFromString(trAss.find("[name=effort]").val(),true);

                //check if the selected resource exists in ganttMaster.resources
                var res= self.master.getOrCreateResource(resId,resName);

                //if resource is not found nor created
                if (!res)
                    return;

                //check if an existing assig has been deleted and re-created with the same values
                var found = false;
                for (var i = 0; i < task.assigs.length; i++) {
                    var ass = task.assigs[i];

                    if (assId == ass.id) {
                        ass.effort = effort;
                        ass.roleId = roleId;
                        ass.resourceId = res.id;
                        ass.touched = true;
                        found = true;
                        break;

                    } else if (roleId == ass.roleId && res.id == ass.resourceId) {
                        ass.effort = effort;
                        ass.touched = true;
                        found = true;
                        break;

                    }
                }

                if (!found && resId && roleId) { //insert
                    cnt++;
                    //console.debug("adding assig row:", assId,resId,resName,roleId,effort)
                    var ass = task.createAssignment("tmp_" + new Date().getTime()+"_"+cnt, resId, roleId, effort);
                    ass.touched = true;
                }

            });

            //console.debug("task.assigs",task.assigs,task.assigs.length)
            //remove untouched assigs
            task.assigs = task.assigs.filter(function (ass) {
                var ret = ass.touched;
                delete ass.touched;
                return ret;
            });
            //console.debug("task.assigs",task.assigs,task.assigs.length)

            //change dates
            task.setPeriod(Date.parseString(taskEditor.find("#start").val()).getTime(), Date.parseString(taskEditor.find("#end").val()).getTime() + (3600000 * 22));

            //change status
            task.changeStatus(taskEditor.find("#status").val());

            if (self.master.endTransaction()) {
                taskEditor.find(":input").updateOldValue();
                closeBlackPopup();
            }

        });
    }

    taskEditor.attr("alertonchange","true");
    var ndo = createModalPopup(800, 450).append(taskEditor);//.append("<div style='height:800px; background-color:red;'></div>")
    //var ndo = createModalPopup(800, 650).append("<div style='height:300px; background-color:red;'></div>")

    //workload computation
    if (typeof(workloadDatesChanged)=="function")
        workloadDatesChanged();



};



/*
 Copyright (c) 2012-2017 Open Lab
 Written by Roberto Bicchierai and Silvia Chelazzi http://roberto.open-lab.com
 Permission is hereby granted, free of charge, to any person obtaining
 a copy of this software and associated documentation files (the
 "Software"), to deal in the Software without restriction, including
 without limitation the rights to use, copy, modify, merge, publish,
 distribute, sublicense, and/or sell copies of the Software, and to
 permit persons to whom the Software is furnished to do so, subject to
 the following conditions:

 The above copyright notice and this permission notice shall be
 included in all copies or substantial portions of the Software.

 THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */
function GanttMaster() {
    this.tasks = [];
    this.deletedTaskIds = [];
    this.links = [];

    this.editor; //element for editor
    this.gantt; //element for gantt
    this.splitter; //element for splitter

    this.isMultiRoot=false; // set to true in case of tasklist

    this.element;


    this.resources; //list of resources
    this.roles;  //list of roles

    this.minEditableDate = 0;
    this.maxEditableDate = Infinity;
    this.set100OnClose=false;

    this.fillWithEmptyLines=true; //when is used by widget it could be usefull to do not fill with empty lines

    this.minRowsInEditor=30; // number of rows always visible in editor

    this.permissions = {
        canWriteOnParent: true,
        canWrite: true,
        canAdd: true,
        canInOutdent: true,
        canMoveUpDown: true,
        canSeePopEdit: true,
        canSeeFullEdit: true,
        canSeeDep: true,
        canSeeCriticalPath: true,
        canAddIssue: false,
        cannotCloseTaskIfIssueOpen: false
    };

    this.firstDayOfWeek = Date.firstDayOfWeek;
    this.serverClientTimeOffset = 0;

    this.currentTask; // task currently selected;

    this.resourceUrl = "jQueryGantt/res/"; // URL to resources (images etc.)
    this.__currentTransaction;  // a transaction object holds previous state during changes
    this.__undoStack = [];
    this.__redoStack = [];
    this.__inUndoRedo = false; // a control flag to avoid Undo/Redo stacks reset when needed

    var self = this;
}


GanttMaster.prototype.init = function (place) {
    this.element = place;
    var self = this;
    //load templates
    $("#gantEditorTemplates").loadTemplates().remove();

    //create editor
    this.editor = new GridEditor(this);
    place.append(this.editor.gridified);

    //create gantt
    this.gantt = new Ganttalendar("m", new Date().getTime() - 3600000 * 24 * 2, new Date().getTime() + 3600000 * 24 * 15, this, place.width() * .6);

    //setup splitter
    self.splitter = $.splittify.init(place, this.editor.gridified, this.gantt.element, 60);
    self.splitter.firstBoxMinWidth = 5;
    self.splitter.secondBoxMinWidth = 20;

    //prepend buttons
    var ganttButtons = $.JST.createFromTemplate({}, "GANTBUTTONS");
    //hide buttons basing on permissions
    if (!self.permissions.canWrite)
        ganttButtons.find(".requireCanWrite").hide();

    if (!self.permissions.canAdd)
        ganttButtons.find(".requireCanAdd").hide();

    if (!self.permissions.canInOutdent)
        ganttButtons.find(".requireCanInOutdent").hide();

    if (!self.permissions.canMoveUpDown)
        ganttButtons.find(".requireCanMoveUpDown").hide();

    if (!self.permissions.canSeeCriticalPath)
        ganttButtons.find(".requireCanSeeCriticalPath").hide();

    if (!self.permissions.canAddIssue)
        ganttButtons.find(".requireCanAddIssue").hide();

    place.before(ganttButtons);


    //bindings
    place.bind("refreshTasks.gantt", function () {
        self.redrawTasks();
    }).bind("refreshTask.gantt", function (e, task) {
        self.drawTask(task);

    }).bind("deleteCurrentTask.gantt", function (e) {
        self.deleteCurrentTask();
    }).bind("addAboveCurrentTask.gantt", function () {
        self.addAboveCurrentTask();
    }).bind("addBelowCurrentTask.gantt", function () {
        self.addBelowCurrentTask();
    }).bind("indentCurrentTask.gantt", function () {
        self.indentCurrentTask();
    }).bind("outdentCurrentTask.gantt", function () {
        self.outdentCurrentTask();
    }).bind("moveUpCurrentTask.gantt", function () {
        self.moveUpCurrentTask();
    }).bind("moveDownCurrentTask.gantt", function () {
        self.moveDownCurrentTask();
    }).bind("collapseAll.gantt", function () {
        self.collapseAll();
    }).bind("expandAll.gantt", function () {
        self.expandAll();



    }).bind("zoomPlus.gantt", function () {
        self.gantt.zoomGantt(true);
    }).bind("zoomMinus.gantt", function () {
        self.gantt.zoomGantt(false);

    }).bind("addIssue.gantt", function () {
        self.addIssue();

    }).bind("undo.gantt", function () {
        if (!self.permissions.canWrite)
            return;
        self.undo();
    }).bind("redo.gantt", function () {
        if (!self.permissions.canWrite)
            return;
        self.redo();
    }).bind("resize.gantt", function () {
        self.resize();
    });


    //keyboard management bindings
    $("body").bind("keydown.body", function (e) {
        //console.debug(e.keyCode+ " "+e.target.nodeName, e.ctrlKey)

        var eventManaged = true;
        var isCtrl = e.ctrlKey || e.metaKey;
        var bodyOrSVG = e.target.nodeName.toLowerCase() == "body" || e.target.nodeName.toLowerCase() == "svg";
        var inWorkSpace=$(e.target).closest("#workSpace").length>0;

        //store focused field
        var focusedField=$(":focus");
        var focusedSVGElement = self.gantt.element.find(".focused.focused");// orrible hack for chrome that seems to keep in memory a cached object

        var isFocusedSVGElement=focusedSVGElement.length >0;

        if ((inWorkSpace ||isFocusedSVGElement) && isCtrl && e.keyCode == 37) { // CTRL+LEFT on the grid
            self.outdentCurrentTask();
            focusedField.focus();

        } else if (inWorkSpace && isCtrl && e.keyCode == 38) { // CTRL+UP   on the grid
            self.moveUpCurrentTask();
            focusedField.focus();

        } else if (inWorkSpace && isCtrl && e.keyCode == 39) { //CTRL+RIGHT  on the grid
            self.indentCurrentTask();
            focusedField.focus();

        } else if (inWorkSpace && isCtrl && e.keyCode == 40) { //CTRL+DOWN   on the grid
            self.moveDownCurrentTask();
            focusedField.focus();

        } else if (isCtrl && e.keyCode == 89) { //CTRL+Y
            self.redo();

        } else if (isCtrl && e.keyCode == 90) { //CTRL+Y
            self.undo();


        } else if ( (isCtrl && inWorkSpace) &&   (e.keyCode == 8 || e.keyCode == 46)  ) { //CTRL+DEL CTRL+BACKSPACE  on grid
            self.deleteCurrentTask();

        } else if ( focusedSVGElement.is(".taskBox") &&   (e.keyCode == 8 || e.keyCode == 46)  ) { //DEL BACKSPACE  svg task
            self.deleteCurrentTask();

        } else if ( focusedSVGElement.is(".linkGroup") &&   (e.keyCode == 8 || e.keyCode == 46)  ) { //DEL BACKSPACE  svg link
            self.removeLink(focused.data("from"), focused.data("to"));

        } else {
            eventManaged=false;
        }


        if (eventManaged) {
            e.preventDefault();
            e.stopPropagation();
        }

    });

    //ask for comment input
    $("#saveGanttButton").after($('#LOG_CHANGES_CONTAINER'));

    //ask for comment management
    this.element.on("gantt.saveRequired",this.manageSaveRequired)

};

GanttMaster.messages = {
    "CANNOT_WRITE":                          "CANNOT_WRITE",
    "CHANGE_OUT_OF_SCOPE":                   "NO_RIGHTS_FOR_UPDATE_PARENTS_OUT_OF_EDITOR_SCOPE",
    "START_IS_MILESTONE":                    "START_IS_MILESTONE",
    "END_IS_MILESTONE":                      "END_IS_MILESTONE",
    "TASK_HAS_CONSTRAINTS":                  "TASK_HAS_CONSTRAINTS",
    "GANTT_ERROR_DEPENDS_ON_OPEN_TASK":      "GANTT_ERROR_DEPENDS_ON_OPEN_TASK",
    "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK": "GANTT_ERROR_DESCENDANT_OF_CLOSED_TASK",
    "TASK_HAS_EXTERNAL_DEPS":                "TASK_HAS_EXTERNAL_DEPS",
    "GANTT_ERROR_LOADING_DATA_TASK_REMOVED": "GANTT_ERROR_LOADING_DATA_TASK_REMOVED",
    "CIRCULAR_REFERENCE":                    "CIRCULAR_REFERENCE",
    "CANNOT_MOVE_TASK":                      "CANNOT_MOVE_TASK",
    "CANNOT_DEPENDS_ON_ANCESTORS":           "CANNOT_DEPENDS_ON_ANCESTORS",
    "CANNOT_DEPENDS_ON_DESCENDANTS":         "CANNOT_DEPENDS_ON_DESCENDANTS",
    "INVALID_DATE_FORMAT":                   "INVALID_DATE_FORMAT",
    "GANTT_QUARTER_SHORT":                   "GANTT_QUARTER_SHORT",
    "GANTT_SEMESTER_SHORT":                  "GANTT_SEMESTER_SHORT",
    "CANNOT_CLOSE_TASK_IF_OPEN_ISSUE":       "CANNOT_CLOSE_TASK_IF_OPEN_ISSUE",
    "PLEASE_SAVE_PROJECT":                   "PLEASE_SAVE_PROJECT"
};


GanttMaster.prototype.createTask = function (id, name, code, level, start, duration) {
    var factory = new TaskFactory();
    return factory.build(id, name, code, level, start, duration);
};


GanttMaster.prototype.getOrCreateResource = function (id, name) {
    var res= this.getResource(id);
    if (!res && id && name) {
        res = this.createResource(id, name);
    }
    return res
};

GanttMaster.prototype.createResource = function (id, name) {
    var res = new Resource(id, name);
    this.resources.push(res);
    return res;
};


//update depends strings
GanttMaster.prototype.updateDependsStrings = function () {
    //remove all deps
    for (var i = 0; i < this.tasks.length; i++) {
        this.tasks[i].depends = "";
    }

    for (var i = 0; i < this.links.length; i++) {
        var link = this.links[i];
        var dep = link.to.depends;
        link.to.depends = link.to.depends + (link.to.depends == "" ? "" : ",") + (link.from.getRow() + 1) + (link.lag ? ":" + link.lag : "");
    }

};

GanttMaster.prototype.removeLink = function (fromTask, toTask) {
    //console.debug("removeLink");
    if (!this.permissions.canWrite || (!fromTask.canWrite && !toTask.canWrite))
        return;

    this.beginTransaction();
    var found = false;
    for (var i = 0; i < this.links.length; i++) {
        if (this.links[i].from == fromTask && this.links[i].to == toTask) {
            this.links.splice(i, 1);
            found = true;
            break;
        }
    }

    if (found) {
        this.updateDependsStrings();
        if (this.updateLinks(toTask))
            this.changeTaskDates(toTask, toTask.start, toTask.end); // fake change to force date recomputation from dependencies
    }
    this.endTransaction();
};

GanttMaster.prototype.removeAllLinks = function (task, openTrans) {
    //console.debug("removeLink");
    if (!this.permissions.canWrite || (!task.canWrite && !task.canWrite))
        return;

    if (openTrans)
        this.beginTransaction();
    var found = false;
    for (var i = 0; i < this.links.length; i++) {
        if (this.links[i].from == task || this.links[i].to == task) {
            this.links.splice(i, 1);
            found = true;
        }
    }

    if (found) {
        this.updateDependsStrings();
    }
    if (openTrans)
        this.endTransaction();
};

//------------------------------------  ADD TASK --------------------------------------------
GanttMaster.prototype.addTask = function (task, row) {
    //console.debug("master.addTask",task,row,this);
    if (!this.permissions.canWrite || !this.permissions.canAdd )
        return;

    task.master = this; // in order to access controller from task

    //replace if already exists
    var pos = -1;
    for (var i = 0; i < this.tasks.length; i++) {
        if (task.id == this.tasks[i].id) {
            pos = i;
            break;
        }
    }

    if (pos >= 0) {
        this.tasks.splice(pos, 1);
        row = parseInt(pos);
    }

    //add task in collection
    if (typeof(row) != "number") {
        this.tasks.push(task);
    } else {
        this.tasks.splice(row, 0, task);

        //recompute depends string
        this.updateDependsStrings();
    }

    //add Link collection in memory
    var linkLoops = !this.updateLinks(task);

    //set the status according to parent
    if (task.getParent())
        task.status = task.getParent().status;
    else
        task.status = "STATUS_ACTIVE";

    var ret = task;
    if (linkLoops || !task.setPeriod(task.start, task.end)) {
        //remove task from in-memory collection
        //console.debug("removing task from memory",task);
        this.tasks.splice(task.getRow(), 1);
        ret = undefined;
    } else {
        //append task to editor
        this.editor.addTask(task, row);
        //append task to gantt
        this.gantt.addTask(task);
    }

//trigger addedTask event
    $(this.element).trigger("addedTask.gantt", task);
    return ret;
};


/**
 * a project contais tasks, resources, roles, and info about permisions
 * @param project
 */
GanttMaster.prototype.loadProject = function (project) {
    //console.debug("loadProject", project)
    this.beginTransaction();
    this.serverClientTimeOffset = typeof project.serverTimeOffset !="undefined"? (parseInt(project.serverTimeOffset) + new Date().getTimezoneOffset() * 60000) : 0;
    this.resources = project.resources;
    this.roles = project.roles;
    this.permissions.canWrite = project.canWrite;
    this.permissions.canWriteOnParent = project.canWriteOnParent;
    this.permissions.cannotCloseTaskIfIssueOpen = project.cannotCloseTaskIfIssueOpen;

    if (project.minEditableDate)
        this.minEditableDate = computeStart(project.minEditableDate);
    else
        this.minEditableDate = -Infinity;

    if (project.maxEditableDate)
        this.maxEditableDate = computeEnd(project.maxEditableDate);
    else
        this.maxEditableDate = Infinity;


    //recover stored ccollapsed statuas
    var collTasks=this.loadCollapsedTasks();

    //shift dates in order to have client side the same hour (e.g.: 23:59) of the server side
    for (var i = 0; i < project.tasks.length; i++) {
        var task = project.tasks[i];
        task.start += this.serverClientTimeOffset;
        task.end += this.serverClientTimeOffset;

        //set initial collapsed status
        task.collapsed=collTasks.indexOf(task.id)>=0;
    }


    this.loadTasks(project.tasks, project.selectedRow);
    this.deletedTaskIds = [];

    //recover saved zoom level
    if (project.zoom){
        this.gantt.zoom = project.zoom;
    }


    this.endTransaction();
    var self = this;
    this.gantt.element.oneTime(200, function () {self.gantt.centerOnToday()});



};


GanttMaster.prototype.loadTasks = function (tasks, selectedRow) {
    //console.debug("GanttMaster.prototype.loadTasks")
    var factory = new TaskFactory();
    //reset
    this.reset();

    for (var i = 0; i < tasks.length; i++) {
        var task = tasks[i];
        if (!(task instanceof Task)) {
            var t = factory.build(task.id, task.name, task.code, task.level, task.start, task.duration, task.collapsed);
            for (var key in task) {
                if (key != "end" && key != "start")
                    t[key] = task[key]; //copy all properties
            }
            task = t;
        }
        task.master = this; // in order to access controller from task
        this.tasks.push(task);  //append task at the end
    }

    //var prof=new Profiler("gm_loadTasks_addTaskLoop");
    for (var i = 0; i < this.tasks.length; i++) {
        var task = this.tasks[i];


        var numOfError = this.__currentTransaction && this.__currentTransaction.errors ? this.__currentTransaction.errors.length : 0;
        //add Link collection in memory
        while (!this.updateLinks(task)) {  // error on update links while loading can be considered as "warning". Can be displayed and removed in order to let transaction commits.
            if (this.__currentTransaction && numOfError != this.__currentTransaction.errors.length) {
                var msg = "ERROR:\n";
                while (numOfError < this.__currentTransaction.errors.length) {
                    var err = this.__currentTransaction.errors.pop();
                    msg = msg + err.msg + "\n\n";
                }
                alert(msg);
            }
            this.removeAllLinks(task, false);
        }

        if (!task.setPeriod(task.start, task.end)) {
            alert(GanttMaster.messages.GANNT_ERROR_LOADING_DATA_TASK_REMOVED + "\n" + task.name );
            //remove task from in-memory collection
            this.tasks.splice(task.getRow(), 1);
        } else {
            //append task to editor
            this.editor.addTask(task, null, true);
            //append task to gantt
            this.gantt.addTask(task);
        }
    }

    //this.editor.fillEmptyLines();
    //prof.stop();

    // re-select old row if tasks is not empty
    if (this.tasks && this.tasks.length > 0) {
        selectedRow = selectedRow ? selectedRow : 0;
        this.tasks[selectedRow].rowElement.click();
    }
};


GanttMaster.prototype.getTask = function (taskId) {
    var ret;
    for (var i = 0; i < this.tasks.length; i++) {
        var tsk = this.tasks[i];
        if (tsk.id == taskId) {
            ret = tsk;
            break;
        }
    }
    return ret;
};


GanttMaster.prototype.getResource = function (resId) {
    var ret;
    for (var i = 0; i < this.resources.length; i++) {
        var res = this.resources[i];
        if (res.id == resId) {
            ret = res;
            break;
        }
    }
    return ret;
};


GanttMaster.prototype.changeTaskDeps = function (task) {
    return task.moveTo(task.start);
};

GanttMaster.prototype.changeTaskDates = function (task, start, end) {
    return task.setPeriod(start, end);
};


GanttMaster.prototype.moveTask = function (task, newStart) {
    return task.moveTo(newStart, true);
};


GanttMaster.prototype.taskIsChanged = function () {
    //console.debug("taskIsChanged");
    var master = this;

    //refresh is executed only once every 50ms
    this.element.stopTime("gnnttaskIsChanged");
    //var profilerext = new Profiler("gm_taskIsChangedRequest");
    this.element.oneTime(50, "gnnttaskIsChanged", function () {
        //console.debug("task Is Changed real call to redraw");
        //var profiler = new Profiler("gm_taskIsChangedReal");
        master.editor.redraw();
        master.gantt.refreshGantt();
        master.element.trigger("gantt.refreshGanttCompleted");
        //profiler.stop();
    });
    //profilerext.stop();
};


GanttMaster.prototype.redraw = function () {
    this.editor.redraw();
    this.gantt.refreshGantt();

};

GanttMaster.prototype.reset = function () {
    //console.debug("GanttMaster.prototype.reset");
    this.tasks = [];
    this.links = [];
    this.deletedTaskIds = [];
    if (!this.__inUndoRedo) {
        this.__undoStack = [];
        this.__redoStack = [];
    } else { // don't reset the stacks if we're in an Undo/Redo, but restart the inUndoRedo control
        this.__inUndoRedo = false;
    }
    delete this.currentTask;

    this.editor.reset();
    this.gantt.reset();
};


GanttMaster.prototype.showTaskEditor = function (taskId) {
    var task = this.getTask(taskId);
    task.rowElement.find(".edit").click();
};

GanttMaster.prototype.saveProject = function () {
    return this.saveGantt(false);
};

GanttMaster.prototype.saveGantt = function (forTransaction) {
    //var prof = new Profiler("gm_saveGantt");
    var saved = [];
    for (var i = 0; i < this.tasks.length; i++) {
        var task = this.tasks[i];
        var cloned = task.clone();
        delete cloned.master;
        delete cloned.rowElement;
        delete cloned.ganttElement;

        //shift back to server side timezone
        if (!forTransaction) {
            cloned.start -= this.serverClientTimeOffset;
            cloned.end -= this.serverClientTimeOffset;
        }

        saved.push(cloned);
    }

    var ret = {tasks: saved};
    if (this.currentTask) {
        ret.selectedRow = this.currentTask.getRow();
    }

    ret.deletedTaskIds = this.deletedTaskIds;  //this must be consistent with transactions and undo

    if (!forTransaction) {
        ret.resources = this.resources;
        ret.roles = this.roles;
        ret.canWrite = this.permissions.canWrite;
        ret.canWriteOnParent = this.permissions.canWriteOnParent;
        ret.zoom = this.gantt.zoom;

        //save collapsed tasks on localStorage
        this.storeCollapsedTasks();

        //mark un-changed task and assignments
        this.markUnChangedTasksAndAssignments(ret);

        //si aggiunge il commento al cambiamento di date/status
        ret.changesReasonWhy=$("#LOG_CHANGES").val();

    }

    //prof.stop();
    return ret;
};


GanttMaster.prototype.markUnChangedTasksAndAssignments=function(newProject){
    //console.debug("markUnChangedTasksAndAssignments");
    //si controlla che ci sia qualcosa di cambiato, ovvero che ci sia l'undo stack
    if (this.__undoStack.length>0){
        var oldProject=JSON.parse(ge.__undoStack[0]);
        //si looppano i "nuovi" task
        for (var i=0;i<newProject.tasks.length;i++){
            var newTask=newProject.tasks[i];
            //se è un task che c'erà già
            if (typeof (newTask.id)=="String" && !newTask.id.startsWith("tmp_")){
                //si recupera il vecchio task
                var oldTask;
                for (var j=0;j<oldProject.tasks.length;j++){
                    if (oldProject.tasks[j].id==newTask.id){
                        oldTask=oldProject.tasks[j];
                        break;
                    }
                }

                //si controlla se ci sono stati cambiamenti
                var taskChanged=
                    oldTask.id != newTask.id ||
                    oldTask.code != newTask.code ||
                    oldTask.name != newTask.name ||
                    oldTask.start != newTask.start ||
                    oldTask.startIsMilestone != newTask.startIsMilestone ||
                    oldTask.end != newTask.end ||
                    oldTask.endIsMilestone != newTask.endIsMilestone ||
                    oldTask.duration != newTask.duration ||
                    oldTask.status != newTask.status ||
                    oldTask.typeId != newTask.typeId ||
                    oldTask.relevance != newTask.relevance ||
                    oldTask.progress != newTask.progress ||
                    oldTask.progressByWorklog != newTask.progressByWorklog ||
                    oldTask.description != newTask.description ||
                    oldTask.level != newTask.level||
                    oldTask.depends != newTask.depends;

                newTask.unchanged=!taskChanged;


                //se ci sono assegnazioni
                if (newTask.assigs&&newTask.assigs.length>0){

                    //se abbiamo trovato il vecchio task e questo aveva delle assegnazioni
                    if (oldTask && oldTask.assigs && oldTask.assigs.length>0){
                        for (var j=0;j<oldTask.assigs.length;j++){
                            var oldAssig=oldTask.assigs[j];
                            //si cerca la nuova assegnazione corrispondente
                            var newAssig;
                            for (var k=0;k<newTask.assigs.length;k++){
                                if(oldAssig.id==newTask.assigs[k].id){
                                    newAssig=newTask.assigs[k];
                                    break;
                                }
                            }

                            //se c'è una nuova assig corrispondente
                            if(newAssig){
                                //si confrontano i valori per vedere se è cambiata
                                newAssig.unchanged=
                                    newAssig.resourceId==oldAssig.resourceId &&
                                    newAssig.roleId==oldAssig.roleId &&
                                    newAssig.effort==oldAssig.effort;
                            }
                        }
                    }
                }
            }
        }
    }
};


GanttMaster.prototype.loadCollapsedTasks = function () {
    var collTasks=[];
    if (localStorage ) {
        if (localStorage.getObject("TWPGanttCollTasks"))
            collTasks = localStorage.getObject("TWPGanttCollTasks");
        return collTasks;
    }
};

GanttMaster.prototype.storeCollapsedTasks = function () {
    //console.debug("storeCollapsedTasks");
    if (localStorage) {
        var collTasks;
        if (!localStorage.getObject("TWPGanttCollTasks"))
            collTasks = [];
        else
            collTasks = localStorage.getObject("TWPGanttCollTasks");


        for (var i = 0; i < this.tasks.length; i++) {
            var task = this.tasks[i];

            var pos=collTasks.indexOf(task.id);
            if (task.collapsed){
                if (pos<0)
                    collTasks.push(task.id);
            } else {
                if (pos>=0)
                    collTasks.splice(pos,1);
            }
        }
        localStorage.setObject("TWPGanttCollTasks", collTasks);
    }
};



GanttMaster.prototype.updateLinks = function (task) {
    //console.debug("updateLinks",task);
    //var prof= new Profiler("gm_updateLinks");

    // defines isLoop function
    function isLoop(task, target, visited) {
        //var prof= new Profiler("gm_isLoop");
        //console.debug("isLoop :"+task.name+" - "+target.name);
        if (target == task) {
            return true;
        }

        var sups = task.getSuperiors();

        //my parent' superiors are my superiors too
        var p = task.getParent();
        while (p) {
            sups = sups.concat(p.getSuperiors());
            p = p.getParent();
        }

        //my children superiors are my superiors too
        var chs = task.getChildren();
        for (var i = 0; i < chs.length; i++) {
            sups = sups.concat(chs[i].getSuperiors());
        }

        var loop = false;
        //check superiors
        for (var i = 0; i < sups.length; i++) {
            var supLink = sups[i];
            if (supLink.from == target) {
                loop = true;
                break;
            } else {
                if (visited.indexOf(supLink.from.id + "x" + target.id) <= 0) {
                    visited.push(supLink.from.id + "x" + target.id);
                    if (isLoop(supLink.from, target, visited)) {
                        loop = true;
                        break;
                    }
                }
            }
        }

        //check target parent
        var tpar = target.getParent();
        if (tpar) {
            if (visited.indexOf(task.id + "x" + tpar.id) <= 0) {
                visited.push(task.id + "x" + tpar.id);
                if (isLoop(task, tpar, visited)) {
                    loop = true;
                }
            }
        }

        //prof.stop();
        return loop;
    }

    //remove my depends
    this.links = this.links.filter(function (link) {
        return link.to != task;
    });

    var todoOk = true;
    if (task.depends) {

        //cannot depend from an ancestor
        var parents = task.getParents();
        //cannot depend from descendants
        var descendants = task.getDescendant();

        var deps = task.depends.split(",");
        var newDepsString = "";

        var visited = [];
        for (var j = 0; j < deps.length; j++) {
            var dep = deps[j]; // in the form of row(lag) e.g. 2:3,3:4,5
            var par = dep.split(":");
            var lag = 0;

            if (par.length > 1) {
                lag = parseInt(par[1]);
            }

            var sup = this.tasks[parseInt(par[0] - 1)];

            if (sup) {
                if (parents && parents.indexOf(sup) >= 0) {
                    this.setErrorOnTransaction("\""+task.name + "\"\n" + GanttMaster.messages.CANNOT_DEPENDS_ON_ANCESTORS + "\n\"" + sup.name+"\"");
                    todoOk = false;

                } else if (descendants && descendants.indexOf(sup) >= 0) {
                    this.setErrorOnTransaction("\""+task.name + "\"\n" + GanttMaster.messages.CANNOT_DEPENDS_ON_DESCENDANTS + "\n\"" + sup.name+"\"");
                    todoOk = false;

                } else if (isLoop(sup, task, visited)) {
                    todoOk = false;
                    this.setErrorOnTransaction(GanttMaster.messages.CIRCULAR_REFERENCE + "\n\"" + task.name + "\" -> \"" + sup.name+"\"");
                } else {
                    this.links.push(new Link(sup, task, lag));
                    newDepsString = newDepsString + (newDepsString.length > 0 ? "," : "") + dep;
                }
            }
        }

        task.depends = newDepsString;

    }

    //prof.stop();

    return todoOk;
};


GanttMaster.prototype.moveUpCurrentTask = function () {
    var self = this;
    //console.debug("moveUpCurrentTask",self.currentTask)
    if (!self.permissions.canWrite  || !self.currentTask.canWrite || !self.permissions.canMoveUpDown )
        return;

    if (self.currentTask) {
        self.beginTransaction();
        self.currentTask.moveUp();
        self.endTransaction();
    }
};

GanttMaster.prototype.moveDownCurrentTask = function () {
    var self = this;
    //console.debug("moveDownCurrentTask",self.currentTask)
    if (!self.permissions.canWrite  || !self.currentTask.canWrite || !self.permissions.canMoveUpDown )
        return;

    if (self.currentTask) {
        self.beginTransaction();
        self.currentTask.moveDown();
        self.endTransaction();
    }
};

GanttMaster.prototype.outdentCurrentTask = function () {
    var self = this;
    if (!self.permissions.canWrite || !self.currentTask.canWrite  || !self.permissions.canInOutdent)
        return;

    if (self.currentTask) {
        var par = self.currentTask.getParent();

        self.beginTransaction();
        self.currentTask.outdent();
        self.endTransaction();

        //[expand]
        if (par) self.editor.refreshExpandStatus(par);
    }
};

GanttMaster.prototype.indentCurrentTask = function () {
    var self = this;
    if (!self.permissions.canWrite || !self.currentTask.canWrite|| !self.permissions.canInOutdent)
        return;

    if (self.currentTask) {
        self.beginTransaction();
        self.currentTask.indent();
        self.endTransaction();
    }
};

GanttMaster.prototype.addBelowCurrentTask = function () {
    var self = this;
    if (!self.permissions.canWrite|| !self.permissions.canAdd)
        return;

    var factory = new TaskFactory();
    var ch;
    var row = 0;
    if (self.currentTask && self.currentTask.name) {
        ch = factory.build("tmp_" + new Date().getTime(), "", "", self.currentTask.level + 1, self.currentTask.start, 1);
        row = self.currentTask.getRow() + 1;

        if (row>0) {
            self.beginTransaction();
            var task = self.addTask(ch, row);
            if (task) {
                task.rowElement.click();
                task.rowElement.find("[name=name]").focus();
            }
            self.endTransaction();
        }
    }
};

GanttMaster.prototype.addAboveCurrentTask = function () {
    var self = this;
    if (!self.permissions.canWrite || !self.permissions.canAdd)
        return;
    var factory = new TaskFactory();

    var ch;
    var row = 0;
    if (self.currentTask  && self.currentTask.name) {
        //cannot add brothers to root
        if (self.currentTask.level <= 0)
            return;

        ch = factory.build("tmp_" + new Date().getTime(), "", "", self.currentTask.level, self.currentTask.start, 1);
        row = self.currentTask.getRow();

        if (row > 0) {
            self.beginTransaction();
            var task = self.addTask(ch, row);
            if (task) {
                task.rowElement.click();
                task.rowElement.find("[name=name]").focus();
            }
            self.endTransaction();
        }
    }
};

GanttMaster.prototype.deleteCurrentTask = function () {
    //console.debug("deleteCurrentTask",this.currentTask , this.isMultiRoot)
    var self = this;
    if (!self.currentTask || !self.permissions.canWrite || !self.currentTask.canWrite)
        return;
    var row = self.currentTask.getRow();
    if (self.currentTask && (row > 0 || self.isMultiRoot || self.currentTask.isNew()) ) {
        var par = self.currentTask.getParent();
        self.beginTransaction();
        self.currentTask.deleteTask();
        self.currentTask = undefined;

        //recompute depends string
        self.updateDependsStrings();

        //redraw
        self.redraw();

        //[expand]
        if (par) self.editor.refreshExpandStatus(par);


        //focus next row
        row = row > self.tasks.length - 1 ? self.tasks.length - 1 : row;
        if (row >= 0) {
            self.currentTask = self.tasks[row];
            self.currentTask.rowElement.click();
            self.currentTask.rowElement.find("[name=name]").focus();
        }
        self.endTransaction();
    }
};




GanttMaster.prototype.collapseAll = function () {
    //console.debug("collapseAll");
    if (this.currentTask){
        this.currentTask.collapsed=true;
        var desc = this.currentTask.getDescendant();
        for (var i=0; i<desc.length; i++) {
            if (desc[i].isParent()) // set collapsed only if is a parent
                desc[i].collapsed = true;
            desc[i].rowElement.hide();
        }

        this.redraw();

        //store collapse statuses
        this.storeCollapsedTasks();
    }
};

GanttMaster.prototype.expandAll = function () {
    //console.debug("expandAll");
    if (this.currentTask){
        this.currentTask.collapsed=false;
        var desc = this.currentTask.getDescendant();
        for (var i=0; i<desc.length; i++) {
            desc[i].collapsed = false;
            desc[i].rowElement.show();
        }

        this.redraw();

        //store collapse statuses
        this.storeCollapsedTasks();

    }
};



GanttMaster.prototype.collapse = function (task, all) {
    console.debug("collapse",task)

    task.collapsed=true;
    task.rowElement.addClass("collapsed");

    var descs = task.getDescendant();
    for (var i = 0; i < descs.length; i++)
        descs[i].rowElement.hide();


    this.gantt.refreshGantt();

    //store collapse statuses
    this.storeCollapsedTasks();

};


GanttMaster.prototype.expand = function (task,all) {
    console.debug("expand",task)
    task.collapsed=false;
    task.rowElement.removeClass("collapsed");

    var collapsedDescendant = this.getCollapsedDescendant();
    var descs = task.getDescendant();
    for (var i = 0; i < descs.length; i++) {
        var childTask = descs[i];
        if (collapsedDescendant.indexOf(childTask) >= 0) continue;
        childTask.rowElement.show();
    }

    this.gantt.refreshGantt();

    //store collapse statuses
    this.storeCollapsedTasks();

};


GanttMaster.prototype.getCollapsedDescendant = function () {
    var allTasks = this.tasks;
    var collapsedDescendant = [];
    for (var i = 0; i < allTasks.length; i++) {
        var task = allTasks[i];
        if (collapsedDescendant.indexOf(task) >= 0) continue;
        if (task.collapsed) collapsedDescendant = collapsedDescendant.concat(task.getDescendant());
    }
    return collapsedDescendant;
}




GanttMaster.prototype.addIssue = function () {
    var self = this;
    if (self.currentTask.isNew()){
        alert(GanttMaster.messages.PLEASE_SAVE_PROJECT);
        return;
    }
    if (!self.currentTask || !self.currentTask.canAddIssue)
        return;

    openIssueEditorInBlack('0',"AD","ISSUE_TASK="+self.currentTask.id);
};

//<%----------------------------- TRANSACTION MANAGEMENT ---------------------------------%>
GanttMaster.prototype.beginTransaction = function () {
    if (!this.__currentTransaction) {
        this.__currentTransaction = {
            snapshot: JSON.stringify(this.saveGantt(true)),
            errors:   []
        };
    } else {
        console.error("Cannot open twice a transaction");
    }
    return this.__currentTransaction;
};


//this function notify an error to a transaction -> transaction will rollback
GanttMaster.prototype.setErrorOnTransaction = function (errorMessage, task) {
    if (this.__currentTransaction) {
        this.__currentTransaction.errors.push({msg: errorMessage, task: task});
    } else {
        console.error(errorMessage);
    }
};

GanttMaster.prototype.isTransactionInError = function () {
    if (!this.__currentTransaction) {
        console.error("Transaction never started.");
        return true;
    } else {
        return this.__currentTransaction.errors.length > 0
    }

};

GanttMaster.prototype.endTransaction = function () {
    if (!this.__currentTransaction) {
        console.error("Transaction never started.");
        return true;
    }

    var ret = true;

    //no error -> commit
    if (this.__currentTransaction.errors.length <= 0) {
        //console.debug("committing transaction");

        //put snapshot in undo
        this.__undoStack.push(this.__currentTransaction.snapshot);
        //clear redo stack
        this.__redoStack = [];

        //shrink gantt bundaries
        this.gantt.originalStartMillis = Infinity;
        this.gantt.originalEndMillis = -Infinity;
        for (var i = 0; i < this.tasks.length; i++) {
            var task = this.tasks[i];
            if (this.gantt.originalStartMillis > task.start)
                this.gantt.originalStartMillis = task.start;
            if (this.gantt.originalEndMillis < task.end)
                this.gantt.originalEndMillis = task.end;

        }
        this.taskIsChanged(); //enqueue for gantt refresh


        //error -> rollback
    } else {
        ret = false;
        //console.debug("rolling-back transaction");

        //compose error message
        var msg = "ERROR:\n";
        for (var i = 0; i < this.__currentTransaction.errors.length; i++) {
            var err = this.__currentTransaction.errors[i];
            msg = msg + err.msg + "\n\n";
        }
        alert(msg);


        //try to restore changed tasks
        var oldTasks = JSON.parse(this.__currentTransaction.snapshot);
        this.deletedTaskIds = oldTasks.deletedTaskIds;
        this.__inUndoRedo = true; // avoid Undo/Redo stacks reset
        this.loadTasks(oldTasks.tasks, oldTasks.selectedRow);
        this.redraw();

    }
    //reset transaction
    this.__currentTransaction = undefined;

    //show/hide save button
    this.saveRequired();

    //[expand]
    this.editor.refreshExpandStatus(this.currentTask);

    return ret;
};

// inhibit undo-redo
GanttMaster.prototype.checkpoint = function () {
    //console.debug("GanttMaster.prototype.checkpoint");
    this.__undoStack = [];
    this.__redoStack = [];
    this.saveRequired();
};

//----------------------------- UNDO/REDO MANAGEMENT ---------------------------------%>

GanttMaster.prototype.undo = function () {
    //console.debug("undo before:",this.__undoStack,this.__redoStack);
    if (this.__undoStack.length > 0) {
        var his = this.__undoStack.pop();
        this.__redoStack.push(JSON.stringify(this.saveGantt()));
        var oldTasks = JSON.parse(his);
        this.deletedTaskIds = oldTasks.deletedTaskIds;
        this.__inUndoRedo = true; // avoid Undo/Redo stacks reset
        this.loadTasks(oldTasks.tasks, oldTasks.selectedRow);
        //console.debug(oldTasks,oldTasks.deletedTaskIds)
        this.redraw();
        //show/hide save button
        this.saveRequired();

        //console.debug("undo after:",this.__undoStack,this.__redoStack);
    }
};

GanttMaster.prototype.redo = function () {
    //console.debug("redo before:",undoStack,redoStack);
    if (this.__redoStack.length > 0) {
        var his = this.__redoStack.pop();
        this.__undoStack.push(JSON.stringify(this.saveGantt()));
        var oldTasks = JSON.parse(his);
        this.deletedTaskIds = oldTasks.deletedTaskIds;
        this.__inUndoRedo = true; // avoid Undo/Redo stacks reset
        this.loadTasks(oldTasks.tasks, oldTasks.selectedRow);
        this.redraw();
        //console.debug("redo after:",undoStack,redoStack);

        this.saveRequired();
    }
};


GanttMaster.prototype.saveRequired = function () {
    //show/hide save button
    if(this.__undoStack.length>0 && this.permissions.canWrite) {
        $("#saveGanttButton").removeClass("disabled");
        $("form[alertOnChange] #Gantt").val(new Date().getTime()); // set a fake variable as dirty
        this.element.trigger("gantt.saveRequired",[true]);


    } else {
        $("#saveGanttButton").addClass("disabled");
        $("form[alertOnChange] #Gantt").updateOldValue(); // set a fake variable as clean
        this.element.trigger("gantt.saveRequired",[false]);

    }
};


GanttMaster.prototype.resize = function () {
    //console.debug("GanttMaster.resize")
    this.splitter.resize();
};



/**
 * Compute the critical path using Backflow algorithm.
 * Translated from Java code supplied by M. Jessup here http://stackoverflow.com/questions/2985317/critical-path-method-algorithm
 *
 * For each task computes:
 * earlyStart, earlyFinish, latestStart, latestFinish, criticalCost
 *
 * A task on the critical path has isCritical=true
 * A task not in critical path can float by latestStart-earlyStart days
 *
 * If you use critical path avoid usage of dependencies between different levels of tasks
 *
 * WARNNG: It ignore milestones!!!!
 * @return {*}
 */
GanttMaster.prototype.computeCriticalPath = function () {

    if (!this.tasks)
        return false;

    // do not consider grouping tasks
    var tasks = this.tasks.filter(function (t) {
        //return !t.isParent()
        return (t.getRow() > 0) && (!t.isParent() || (t.isParent() && !t.isDependent()));
    });

    // reset values
    for (var i = 0; i < tasks.length; i++) {
        var t = tasks[i];
        t.earlyStart = -1;
        t.earlyFinish = -1;
        t.latestStart = -1;
        t.latestFinish = -1;
        t.criticalCost = -1;
        t.isCritical = false;
    }

    // tasks whose critical cost has been calculated
    var completed = [];
    // tasks whose critical cost needs to be calculated
    var remaining = tasks.concat(); // put all tasks in remaining


    // Backflow algorithm
    // while there are tasks whose critical cost isn't calculated.
    while (remaining.length > 0) {
        var progress = false;

        // find a new task to calculate
        for (var i = 0; i < remaining.length; i++) {
            var task = remaining[i];
            var inferiorTasks = task.getInferiorTasks();

            if (containsAll(completed, inferiorTasks)) {
                // all dependencies calculated, critical cost is max dependency critical cost, plus our cost
                var critical = 0;
                for (var j = 0; j < inferiorTasks.length; j++) {
                    var t = inferiorTasks[j];
                    if (t.criticalCost > critical) {
                        critical = t.criticalCost;
                    }
                }
                task.criticalCost = critical + task.duration;
                // set task as calculated an remove
                completed.push(task);
                remaining.splice(i, 1);

                // note we are making progress
                progress = true;
            }
        }
        // If we haven't made any progress then a cycle must exist in
        // the graph and we wont be able to calculate the critical path
        if (!progress) {
            console.error("Cyclic dependency, algorithm stopped!");
            return false;
        }
    }

    // set earlyStart, earlyFinish, latestStart, latestFinish
    computeMaxCost(tasks);
    var initialNodes = initials(tasks);
    calculateEarly(initialNodes);
    calculateCritical(tasks);

    return tasks;


    function containsAll(set, targets) {
        for (var i = 0; i < targets.length; i++) {
            if (set.indexOf(targets[i]) < 0)
                return false;
        }
        return true;
    }

    function computeMaxCost(tasks) {
        var max = -1;
        for (var i = 0; i < tasks.length; i++) {
            var t = tasks[i];

            if (t.criticalCost > max)
                max = t.criticalCost;
        }
        //console.debug("Critical path length (cost): " + max);
        for (var i = 0; i < tasks.length; i++) {
            var t = tasks[i];
            t.setLatest(max);
        }
    }

    function initials(tasks) {
        var initials = [];
        for (var i = 0; i < tasks.length; i++) {
            if (!tasks[i].depends || tasks[i].depends == "")
                initials.push(tasks[i]);
        }
        return initials;
    }

    function calculateEarly(initials) {
        for (var i = 0; i < initials.length; i++) {
            var initial = initials[i];
            initial.earlyStart = 0;
            initial.earlyFinish = initial.duration;
            setEarly(initial);
        }
    }

    function setEarly(initial) {
        var completionTime = initial.earlyFinish;
        var inferiorTasks = initial.getInferiorTasks();
        for (var i = 0; i < inferiorTasks.length; i++) {
            var t = inferiorTasks[i];
            if (completionTime >= t.earlyStart) {
                t.earlyStart = completionTime;
                t.earlyFinish = completionTime + t.duration;
            }
            setEarly(t);
        }
    }

    function calculateCritical(tasks) {
        for (var i = 0; i < tasks.length; i++) {
            var t = tasks[i];
            t.isCritical = (t.earlyStart == t.latestStart)
        }
    }

};

//------------------------------------------- MANAGE CHANGE LOG INPUT ---------------------------------------------------
GanttMaster.prototype.manageSaveRequired=function(ev, showSave) {
    //console.debug("manageSaveRequired", showSave);

    function checkChanges() {
        var changes = false;
        //there is somethin in the redo stack?
        if (ge.__undoStack.length > 0) {
            var oldProject = JSON.parse(ge.__undoStack[0]);
            //si looppano i "nuovi" task
            for (var i = 0; !changes && i < ge.tasks.length; i++) {
                var newTask = ge.tasks[i];
                //se è un task che c'erà già
                if (typeof (newTask.id)=="String" && !newTask.id.startsWith("tmp_")) {
                    //si recupera il vecchio task
                    var oldTask;
                    for (var j = 0; j < oldProject.tasks.length; j++) {
                        if (oldProject.tasks[j].id == newTask.id) {
                            oldTask = oldProject.tasks[j];
                            break;
                        }
                    }
                    // chack only status or dateChanges
                    if (oldTask && (oldTask.status != newTask.status || oldTask.start != newTask.start || oldTask.end != newTask.end)) {
                        changes = true;
                        break;
                    }
                }
            }
        }
        $("#LOG_CHANGES_CONTAINER").css("display", changes ? "inline-block" : "none");
    }


    if (showSave) {
        $("body").stopTime("gantt.manageSaveRequired").oneTime(200, "gantt.manageSaveRequired", checkChanges);
    } else {
        $("#LOG_CHANGES_CONTAINER").hide();
    }

}

