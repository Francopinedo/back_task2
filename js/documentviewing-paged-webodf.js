// Input 0
var webodf_version="0.4.2-1987-g1d0692e-dirty";
// Input 1
function Runtime(){}Runtime.prototype.getVariable=function(g){};Runtime.prototype.toJson=function(g){};Runtime.prototype.fromJson=function(g){};Runtime.prototype.byteArrayFromString=function(g,k){};Runtime.prototype.byteArrayToString=function(g,k){};Runtime.prototype.read=function(g,k,b,p){};Runtime.prototype.readFile=function(g,k,b){};Runtime.prototype.readFileSync=function(g,k){};Runtime.prototype.loadXML=function(g,k){};Runtime.prototype.writeFile=function(g,k,b){};
Runtime.prototype.isFile=function(g,k){};Runtime.prototype.getFileSize=function(g,k){};Runtime.prototype.deleteFile=function(g,k){};Runtime.prototype.log=function(g,k){};Runtime.prototype.setTimeout=function(g,k){};Runtime.prototype.clearTimeout=function(g){};Runtime.prototype.libraryPaths=function(){};Runtime.prototype.currentDirectory=function(){};Runtime.prototype.setCurrentDirectory=function(g){};Runtime.prototype.type=function(){};Runtime.prototype.getDOMImplementation=function(){};
Runtime.prototype.parseXML=function(g){};Runtime.prototype.exit=function(g){};Runtime.prototype.getWindow=function(){};Runtime.prototype.assert=function(g,k,b){};var IS_COMPILED_CODE=!0;
Runtime.byteArrayToString=function(g,k){function b(b){var d="",q,r=b.length;for(q=0;q<r;q+=1)d+=String.fromCharCode(b[q]&255);return d}function p(b){var d="",q,r=b.length,m=[],f,c,a,e;for(q=0;q<r;q+=1)f=b[q],128>f?m.push(f):(q+=1,c=b[q],194<=f&&224>f?m.push((f&31)<<6|c&63):(q+=1,a=b[q],224<=f&&240>f?m.push((f&15)<<12|(c&63)<<6|a&63):(q+=1,e=b[q],240<=f&&245>f&&(f=(f&7)<<18|(c&63)<<12|(a&63)<<6|e&63,f-=65536,m.push((f>>10)+55296,(f&1023)+56320))))),1E3===m.length&&(d+=String.fromCharCode.apply(null,
m),m.length=0);return d+String.fromCharCode.apply(null,m)}var d;"utf8"===k?d=p(g):("binary"!==k&&this.log("Unsupported encoding: "+k),d=b(g));return d};Runtime.getVariable=function(g){try{return eval(g)}catch(k){}};Runtime.toJson=function(g){return JSON.stringify(g)};Runtime.fromJson=function(g){return JSON.parse(g)};Runtime.getFunctionName=function(g){return void 0===g.name?(g=/function\s+(\w+)/.exec(g))&&g[1]:g.name};
function BrowserRuntime(g){function k(f){var c=f.length,a,e,l=0;for(a=0;a<c;a+=1)e=f.charCodeAt(a),l+=1+(128<e)+(2048<e),55040<e&&57344>e&&(l+=1,a+=1);return l}function b(f,c,a){var e=f.length,l,b;c=new Uint8Array(new ArrayBuffer(c));a?(c[0]=239,c[1]=187,c[2]=191,b=3):b=0;for(a=0;a<e;a+=1)l=f.charCodeAt(a),128>l?(c[b]=l,b+=1):2048>l?(c[b]=192|l>>>6,c[b+1]=128|l&63,b+=2):55040>=l||57344<=l?(c[b]=224|l>>>12&15,c[b+1]=128|l>>>6&63,c[b+2]=128|l&63,b+=3):(a+=1,l=(l-55296<<10|f.charCodeAt(a)-56320)+65536,
c[b]=240|l>>>18&7,c[b+1]=128|l>>>12&63,c[b+2]=128|l>>>6&63,c[b+3]=128|l&63,b+=4);return c}function p(f){var c=f.length,a=new Uint8Array(new ArrayBuffer(c)),e;for(e=0;e<c;e+=1)a[e]=f.charCodeAt(e)&255;return a}function d(f,c){var a,e,l;void 0!==c?l=f:c=f;g?(e=g.ownerDocument,l&&(a=e.createElement("span"),a.className=l,a.appendChild(e.createTextNode(l)),g.appendChild(a),g.appendChild(e.createTextNode(" "))),a=e.createElement("span"),0<c.length&&"<"===c[0]?a.innerHTML=c:a.appendChild(e.createTextNode(c)),
g.appendChild(a),g.appendChild(e.createElement("br"))):console&&console.log(c);"alert"===l&&alert(c)}function h(f,c,a){if(0!==a.status||a.responseText)if(200===a.status||0===a.status){if(a.response&&"string"!==typeof a.response)"binary"===c?(a=a.response,a=new Uint8Array(a)):a=String(a.response);else if("binary"===c)if(null!==a.responseBody&&"undefined"!==String(typeof VBArray)){a=(new VBArray(a.responseBody)).toArray();var e=a.length,l=new Uint8Array(new ArrayBuffer(e));for(c=0;c<e;c+=1)l[c]=a[c];
a=l}else{(c=a.getResponseHeader("Content-Length"))&&(c=parseInt(c,10));if(c&&c!==a.responseText.length)a:{var e=a.responseText,l=!1,q=k(e);if("number"===typeof c){if(c!==q&&c!==q+3){e=void 0;break a}l=q+3===c;q=c}e=b(e,q,l)}void 0===e&&(e=p(a.responseText));a=e}else a=a.responseText;m[f]=a;f={err:null,data:a}}else f={err:a.responseText||a.statusText,data:null};else f={err:"File "+f+" is empty.",data:null};return f}function n(f,c,a){var e=new XMLHttpRequest;e.open("GET",f,a);e.overrideMimeType&&("binary"!==
c?e.overrideMimeType("text/plain; charset="+c):e.overrideMimeType("text/plain; charset=x-user-defined"));return e}function q(f,c,a){function e(){var e;4===l.readyState&&(e=h(f,c,l),a(e.err,e.data))}if(m.hasOwnProperty(f))a(null,m[f]);else{var l=n(f,c,!0);l.onreadystatechange=e;try{l.send(null)}catch(b){a(b.message,null)}}}var r=this,m={};this.byteArrayFromString=function(f,c){var a;"utf8"===c?a=b(f,k(f),!1):("binary"!==c&&r.log("unknown encoding: "+c),a=p(f));return a};this.byteArrayToString=Runtime.byteArrayToString;
this.getVariable=Runtime.getVariable;this.fromJson=Runtime.fromJson;this.toJson=Runtime.toJson;this.readFile=q;this.read=function(f,c,a,e){q(f,"binary",function(f,b){var m=null;if(b){if("string"===typeof b)throw"This should not happen.";m=b.subarray(c,c+a)}e(f,m)})};this.readFileSync=function(f,c){var a=n(f,c,!1),e;try{a.send(null);e=h(f,c,a);if(e.err)throw e.err;if(null===e.data)throw"No data read from "+f+".";}catch(l){throw l;}return e.data};this.writeFile=function(f,c,a){m[f]=c;var e=new XMLHttpRequest,
l;e.open("PUT",f,!0);e.onreadystatechange=function(){4===e.readyState&&(0!==e.status||e.responseText?200<=e.status&&300>e.status||0===e.status?a(null):a("Status "+String(e.status)+": "+e.responseText||e.statusText):a("File "+f+" is empty."))};l=c.buffer&&!e.sendAsBinary?c.buffer:r.byteArrayToString(c,"binary");try{e.sendAsBinary?e.sendAsBinary(l):e.send(l)}catch(b){r.log("HUH? "+b+" "+c),a(b.message)}};this.deleteFile=function(f,c){delete m[f];var a=new XMLHttpRequest;a.open("DELETE",f,!0);a.onreadystatechange=
function(){4===a.readyState&&(200>a.status&&300<=a.status?c(a.responseText):c(null))};a.send(null)};this.loadXML=function(f,c){var a=new XMLHttpRequest;a.open("GET",f,!0);a.overrideMimeType&&a.overrideMimeType("text/xml");a.onreadystatechange=function(){4===a.readyState&&(0!==a.status||a.responseText?200===a.status||0===a.status?c(null,a.responseXML):c(a.responseText,null):c("File "+f+" is empty.",null))};try{a.send(null)}catch(e){c(e.message,null)}};this.isFile=function(f,c){r.getFileSize(f,function(a){c(-1!==
a)})};this.getFileSize=function(f,c){if(m.hasOwnProperty(f)&&"string"!==typeof m[f])c(m[f].length);else{var a=new XMLHttpRequest;a.open("HEAD",f,!0);a.onreadystatechange=function(){if(4===a.readyState){var e=a.getResponseHeader("Content-Length");e?c(parseInt(e,10)):q(f,"binary",function(a,e){a?c(-1):c(e.length)})}};a.send(null)}};this.log=d;this.assert=function(f,c,a){if(!f)throw d("alert","ASSERTION FAILED:\n"+c),a&&a(),c;};this.setTimeout=function(f,c){return setTimeout(function(){f()},c)};this.clearTimeout=
function(f){clearTimeout(f)};this.libraryPaths=function(){return["lib"]};this.setCurrentDirectory=function(){};this.currentDirectory=function(){return""};this.type=function(){return"BrowserRuntime"};this.getDOMImplementation=function(){return window.document.implementation};this.parseXML=function(f){return(new DOMParser).parseFromString(f,"text/xml")};this.exit=function(f){d("Calling exit with code "+String(f)+", but exit() is not implemented.")};this.getWindow=function(){return window}}
function NodeJSRuntime(){function g(b){var m=b.length,f,c=new Uint8Array(new ArrayBuffer(m));for(f=0;f<m;f+=1)c[f]=b[f];return c}function k(b,m,f){function c(a,c){if(a)return f(a,null);if(!c)return f("No data for "+b+".",null);if("string"===typeof c)return f(a,c);f(a,g(c))}b=d.resolve(h,b);"binary"!==m?p.readFile(b,m,c):p.readFile(b,null,c)}var b=this,p=require("fs"),d=require("path"),h="",n,q;this.byteArrayFromString=function(b,m){var f=new Buffer(b,m),c,a=f.length,e=new Uint8Array(new ArrayBuffer(a));
for(c=0;c<a;c+=1)e[c]=f[c];return e};this.byteArrayToString=Runtime.byteArrayToString;this.getVariable=Runtime.getVariable;this.fromJson=Runtime.fromJson;this.toJson=Runtime.toJson;this.readFile=k;this.loadXML=function(q,m){k(q,"utf-8",function(f,c){if(f)return m(f,null);if(!c)return m("No data for "+q+".",null);m(null,b.parseXML(c))})};this.writeFile=function(b,m,f){m=new Buffer(m);b=d.resolve(h,b);p.writeFile(b,m,"binary",function(c){f(c||null)})};this.deleteFile=function(b,m){b=d.resolve(h,b);
p.unlink(b,m)};this.read=function(b,m,f,c){b=d.resolve(h,b);p.open(b,"r+",666,function(a,e){if(a)c(a,null);else{var l=new Buffer(f);p.read(e,l,0,f,m,function(a){p.close(e);c(a,g(l))})}})};this.readFileSync=function(b,m){var f;f=p.readFileSync(b,"binary"===m?null:m);if(null===f)throw"File "+b+" could not be read.";"binary"===m&&(f=g(f));return f};this.isFile=function(b,m){b=d.resolve(h,b);p.stat(b,function(f,c){m(!f&&c.isFile())})};this.getFileSize=function(b,m){b=d.resolve(h,b);p.stat(b,function(f,
c){f?m(-1):m(c.size)})};this.log=function(b,m){var f;void 0!==m?f=b:m=b;"alert"===f&&process.stderr.write("\n!!!!! ALERT !!!!!\n");process.stderr.write(m+"\n");"alert"===f&&process.stderr.write("!!!!! ALERT !!!!!\n")};this.assert=function(b,m,f){b||(process.stderr.write("ASSERTION FAILED: "+m),f&&f())};this.setTimeout=function(b,m){return setTimeout(function(){b()},m)};this.clearTimeout=function(b){clearTimeout(b)};this.libraryPaths=function(){return[__dirname]};this.setCurrentDirectory=function(b){h=
b};this.currentDirectory=function(){return h};this.type=function(){return"NodeJSRuntime"};this.getDOMImplementation=function(){return q};this.parseXML=function(b){return n.parseFromString(b,"text/xml")};this.exit=process.exit;this.getWindow=function(){return null};n=new (require("xmldom").DOMParser);q=b.parseXML("<a/>").implementation}
function RhinoRuntime(){function g(b,d){var m;void 0!==d?m=b:d=b;"alert"===m&&print("\n!!!!! ALERT !!!!!");print(d);"alert"===m&&print("!!!!! ALERT !!!!!")}var k=this,b={},p=b.javax.xml.parsers.DocumentBuilderFactory.newInstance(),d,h,n="";p.setValidating(!1);p.setNamespaceAware(!0);p.setExpandEntityReferences(!1);p.setSchema(null);h=b.org.xml.sax.EntityResolver({resolveEntity:function(q,d){var m=new b.java.io.FileReader(d);return new b.org.xml.sax.InputSource(m)}});d=p.newDocumentBuilder();d.setEntityResolver(h);
this.byteArrayFromString=function(b,d){var m,f=b.length,c=new Uint8Array(new ArrayBuffer(f));for(m=0;m<f;m+=1)c[m]=b.charCodeAt(m)&255;return c};this.byteArrayToString=Runtime.byteArrayToString;this.getVariable=Runtime.getVariable;this.fromJson=Runtime.fromJson;this.toJson=Runtime.toJson;this.loadXML=function(q,h){var m=new b.java.io.File(q),f=null;try{f=d.parse(m)}catch(c){return print(c),h(c,null)}h(null,f)};this.readFile=function(d,h,m){n&&(d=n+"/"+d);var f=new b.java.io.File(d),c="binary"===h?
"latin1":h;f.isFile()?((d=readFile(d,c))&&"binary"===h&&(d=k.byteArrayFromString(d,"binary")),m(null,d)):m(d+" is not a file.",null)};this.writeFile=function(d,h,m){n&&(d=n+"/"+d);d=new b.java.io.FileOutputStream(d);var f,c=h.length;for(f=0;f<c;f+=1)d.write(h[f]);d.close();m(null)};this.deleteFile=function(d,h){n&&(d=n+"/"+d);var m=new b.java.io.File(d),f=d+Math.random(),f=new b.java.io.File(f);m.rename(f)?(f.deleteOnExit(),h(null)):h("Could not delete "+d)};this.read=function(d,h,m,f){n&&(d=n+"/"+
d);var c;c=d;var a="binary";(new b.java.io.File(c)).isFile()?("binary"===a&&(a="latin1"),c=readFile(c,a)):c=null;c?f(null,this.byteArrayFromString(c.substring(h,h+m),"binary")):f("Cannot read "+d,null)};this.readFileSync=function(b,d){if(!d)return"";var m=readFile(b,d);if(null===m)throw"File could not be read.";return m};this.isFile=function(d,h){n&&(d=n+"/"+d);var m=new b.java.io.File(d);h(m.isFile())};this.getFileSize=function(d,h){n&&(d=n+"/"+d);var m=new b.java.io.File(d);h(m.length())};this.log=
g;this.assert=function(b,d,m){b||(g("alert","ASSERTION FAILED: "+d),m&&m())};this.setTimeout=function(b){b();return 0};this.clearTimeout=function(){};this.libraryPaths=function(){return["lib"]};this.setCurrentDirectory=function(b){n=b};this.currentDirectory=function(){return n};this.type=function(){return"RhinoRuntime"};this.getDOMImplementation=function(){return d.getDOMImplementation()};this.parseXML=function(h){h=new b.java.io.StringReader(h);h=new b.org.xml.sax.InputSource(h);return d.parse(h)};
this.exit=quit;this.getWindow=function(){return null}}Runtime.create=function(){return"undefined"!==String(typeof window)?new BrowserRuntime(window.document.getElementById("logoutput")):"undefined"!==String(typeof require)?new NodeJSRuntime:new RhinoRuntime};var runtime=Runtime.create(),core={},gui={},xmldom={},odf={},ops={};
(function(){function g(b,d,h){var f=b+"/manifest.json",c,a;runtime.log("Loading manifest: "+f);try{c=runtime.readFileSync(f,"utf-8")}catch(e){if(h)runtime.log("No loadable manifest found.");else throw console.log(String(e)),e;return}h=JSON.parse(c);for(a in h)h.hasOwnProperty(a)&&(d[a]={dir:b,deps:h[a]})}function k(b,d,h){function f(b){if(!e[b]&&!h(b)){if(a[b])throw"Circular dependency detected for "+b+".";a[b]=!0;if(!d[b])throw"Missing dependency information for class "+b+".";var n=d[b],k=n.deps,
p,q=k.length;for(p=0;p<q;p+=1)f(k[p]);a[b]=!1;e[b]=!0;c.push(n.dir+"/"+b.replace(".","/")+".js")}}var c=[],a={},e={};b.forEach(f);return c}function b(b,d){return d=d+("\n//# sourceURL="+b)+("\n//@ sourceURL="+b)}function p(d){var h,m;for(h=0;h<d.length;h+=1)m=runtime.readFileSync(d[h],"utf-8"),m=b(d[h],m),eval(m)}function d(b){b=b.split(".");var d,h=n,f=b.length;for(d=0;d<f;d+=1){if(!h.hasOwnProperty(b[d]))return!1;h=h[b[d]]}return!0}var h,n={core:core,gui:gui,xmldom:xmldom,odf:odf,ops:ops};runtime.loadClasses=
function(b,n){if(IS_COMPILED_CODE||0===b.length)return n&&n();var m;if(!(m=h)){m=[];var f=runtime.libraryPaths(),c;runtime.currentDirectory()&&-1===f.indexOf(runtime.currentDirectory())&&g(runtime.currentDirectory(),m,!0);for(c=0;c<f.length;c+=1)g(f[c],m)}h=m;b=k(b,h,d);if(0===b.length)return n&&n();if("BrowserRuntime"===runtime.type()&&n){m=b;f=document.currentScript||document.documentElement.lastChild;c=document.createDocumentFragment();var a,e;for(e=0;e<m.length;e+=1)a=document.createElement("script"),
a.type="text/javascript",a.charset="utf-8",a.async=!1,a.setAttribute("src",m[e]),c.appendChild(a);n&&(a.onload=n);f.parentNode.insertBefore(c,f)}else p(b),n&&n()};runtime.loadClass=function(b,d){runtime.loadClasses([b],d)}})();(function(){var g=function(k){return k};runtime.getTranslator=function(){return g};runtime.setTranslator=function(k){g=k};runtime.tr=function(k){var b=g(k);return b&&"string"===String(typeof b)?b:k}})();
(function(g){function k(b){if(b.length){var k=b[0];runtime.readFile(k,"utf8",function(d,h){function n(){var b;(b=eval(r))&&runtime.exit(b)}var g="",g=k.lastIndexOf("/"),r=h,g=-1!==g?k.substring(0,g):".";runtime.setCurrentDirectory(g);d?(runtime.log(d),runtime.exit(1)):null===r?(runtime.log("No code found for "+k),runtime.exit(1)):n.apply(null,b)})}}g=g?Array.prototype.slice.call(g):[];"NodeJSRuntime"===runtime.type()?k(process.argv.slice(2)):"RhinoRuntime"===runtime.type()?k(g):k(g.slice(1))})("undefined"!==
String(typeof arguments)&&arguments);
// Input 2
core.Async=function(){this.forEach=function(g,k,b){function p(d){n!==h&&(d?(n=h,b(d)):(n+=1,n===h&&b(null)))}var d,h=g.length,n=0;for(d=0;d<h;d+=1)k(g[d],p)};this.destroyAll=function(g,k){function b(p,d){if(d)k(d);else if(p<g.length)g[p](function(d){b(p+1,d)});else k()}b(0,void 0)}};
// Input 3
function makeBase64(){function g(a){var c,e=a.length,b=new Uint8Array(new ArrayBuffer(e));for(c=0;c<e;c+=1)b[c]=a.charCodeAt(c)&255;return b}function k(a){var c,e="",b,f=a.length-2;for(b=0;b<f;b+=3)c=a[b]<<16|a[b+1]<<8|a[b+2],e+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"[c>>>18],e+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"[c>>>12&63],e+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"[c>>>6&63],e+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"[c&
63];b===f+1?(c=a[b]<<4,e+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"[c>>>6],e+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"[c&63],e+="=="):b===f&&(c=a[b]<<10|a[b+1]<<2,e+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"[c>>>12],e+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"[c>>>6&63],e+="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"[c&63],e+="=");return e}function b(a){a=a.replace(/[^A-Za-z0-9+\/]+/g,
"");var c=a.length,e=new Uint8Array(new ArrayBuffer(3*c)),b=a.length%4,f=0,d,h;for(d=0;d<c;d+=4)h=(l[a.charAt(d)]||0)<<18|(l[a.charAt(d+1)]||0)<<12|(l[a.charAt(d+2)]||0)<<6|(l[a.charAt(d+3)]||0),e[f]=h>>16,e[f+1]=h>>8&255,e[f+2]=h&255,f+=3;c=3*c-[0,0,2,1][b];return e.subarray(0,c)}function p(a){var c,e,b=a.length,f=0,l=new Uint8Array(new ArrayBuffer(3*b));for(c=0;c<b;c+=1)e=a[c],128>e?l[f++]=e:(2048>e?l[f++]=192|e>>>6:(l[f++]=224|e>>>12&15,l[f++]=128|e>>>6&63),l[f++]=128|e&63);return l.subarray(0,
f)}function d(a){var c,e,b,f,l=a.length,d=new Uint8Array(new ArrayBuffer(l)),h=0;for(c=0;c<l;c+=1)e=a[c],128>e?d[h++]=e:(c+=1,b=a[c],224>e?d[h++]=(e&31)<<6|b&63:(c+=1,f=a[c],d[h++]=(e&15)<<12|(b&63)<<6|f&63));return d.subarray(0,h)}function h(a){return k(g(a))}function n(a){return String.fromCharCode.apply(String,b(a))}function q(a){return d(g(a))}function r(a){a=d(a);for(var c="",e=0;e<a.length;)c+=String.fromCharCode.apply(String,a.subarray(e,e+45E3)),e+=45E3;return c}function m(a,c,e){var b,f,
l,d="";for(l=c;l<e;l+=1)c=a.charCodeAt(l)&255,128>c?d+=String.fromCharCode(c):(l+=1,b=a.charCodeAt(l)&255,224>c?d+=String.fromCharCode((c&31)<<6|b&63):(l+=1,f=a.charCodeAt(l)&255,d+=String.fromCharCode((c&15)<<12|(b&63)<<6|f&63)));return d}function f(a,c){function e(){var l=f+1E5;l>a.length&&(l=a.length);b+=m(a,f,l);f=l;l=f===a.length;c(b,l)&&!l&&runtime.setTimeout(e,0)}var b="",f=0;1E5>a.length?c(m(a,0,a.length),!0):("string"!==typeof a&&(a=a.slice()),e())}function c(a){return p(g(a))}function a(a){return String.fromCharCode.apply(String,
p(a))}function e(a){return String.fromCharCode.apply(String,p(g(a)))}var l=function(a){var c={},e,b;e=0;for(b=a.length;e<b;e+=1)c[a.charAt(e)]=e;return c}("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/"),s,t,y=runtime.getWindow(),B,D;y&&y.btoa?(B=y.btoa,s=function(a){return B(e(a))}):(B=h,s=function(a){return k(c(a))});y&&y.atob?(D=y.atob,t=function(a){a=D(a);return m(a,0,a.length)}):(D=n,t=function(a){return r(b(a))});core.Base64=function(){this.convertByteArrayToBase64=this.convertUTF8ArrayToBase64=
k;this.convertBase64ToByteArray=this.convertBase64ToUTF8Array=b;this.convertUTF16ArrayToByteArray=this.convertUTF16ArrayToUTF8Array=p;this.convertByteArrayToUTF16Array=this.convertUTF8ArrayToUTF16Array=d;this.convertUTF8StringToBase64=h;this.convertBase64ToUTF8String=n;this.convertUTF8StringToUTF16Array=q;this.convertByteArrayToUTF16String=this.convertUTF8ArrayToUTF16String=r;this.convertUTF8StringToUTF16String=f;this.convertUTF16StringToByteArray=this.convertUTF16StringToUTF8Array=c;this.convertUTF16ArrayToUTF8String=
a;this.convertUTF16StringToUTF8String=e;this.convertUTF16StringToBase64=s;this.convertBase64ToUTF16String=t;this.fromBase64=n;this.toBase64=h;this.atob=D;this.btoa=B;this.utob=e;this.btou=f;this.encode=s;this.encodeURI=function(a){return s(a).replace(/[+\/]/g,function(a){return"+"===a?"-":"_"}).replace(/\\=+$/,"")};this.decode=function(a){return t(a.replace(/[\-_]/g,function(a){return"-"===a?"+":"/"}))};return this};return core.Base64}core.Base64=makeBase64();
// Input 4
core.ByteArray=function(g){this.pos=0;this.data=g;this.readUInt32LE=function(){this.pos+=4;var k=this.data,b=this.pos;return k[--b]<<24|k[--b]<<16|k[--b]<<8|k[--b]};this.readUInt16LE=function(){this.pos+=2;var k=this.data,b=this.pos;return k[--b]<<8|k[--b]}};
// Input 5
core.ByteArrayWriter=function(g){function k(b){b>d-p&&(d=Math.max(2*d,p+b),b=new Uint8Array(new ArrayBuffer(d)),b.set(h),h=b)}var b=this,p=0,d=1024,h=new Uint8Array(new ArrayBuffer(d));this.appendByteArrayWriter=function(d){b.appendByteArray(d.getByteArray())};this.appendByteArray=function(b){var d=b.length;k(d);h.set(b,p);p+=d};this.appendArray=function(b){var d=b.length;k(d);h.set(b,p);p+=d};this.appendUInt16LE=function(d){b.appendArray([d&255,d>>8&255])};this.appendUInt32LE=function(d){b.appendArray([d&
255,d>>8&255,d>>16&255,d>>24&255])};this.appendString=function(d){b.appendByteArray(runtime.byteArrayFromString(d,g))};this.getLength=function(){return p};this.getByteArray=function(){var b=new Uint8Array(new ArrayBuffer(p));b.set(h.subarray(0,p));return b}};
// Input 6
core.CSSUnits=function(){var g=this,k={"in":1,cm:2.54,mm:25.4,pt:72,pc:12};this.convert=function(b,p,d){return b*k[d]/k[p]};this.convertMeasure=function(b,k){var d,h;b&&k?(d=parseFloat(b),h=b.replace(d.toString(),""),d=g.convert(d,h,k).toString()):d="";return d};this.getUnits=function(b){return b.substr(b.length-2,b.length)}};
// Input 7
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
(function(){function g(){var b,p,d,h,n,g,r,m,f;void 0===k&&(p=(b=runtime.getWindow())&&b.document,g=p.documentElement,r=p.body,k={rangeBCRIgnoresElementBCR:!1,unscaledRangeClientRects:!1,elementBCRIgnoresBodyScroll:!1},p&&(h=p.createElement("div"),h.style.position="absolute",h.style.left="-99999px",h.style.transform="scale(2)",h.style["-webkit-transform"]="scale(2)",n=p.createElement("div"),h.appendChild(n),r.appendChild(h),b=p.createRange(),b.selectNode(n),k.rangeBCRIgnoresElementBCR=0===b.getClientRects().length,
n.appendChild(p.createTextNode("Rect transform test")),p=n.getBoundingClientRect(),d=b.getBoundingClientRect(),k.unscaledRangeClientRects=2<Math.abs(p.height-d.height),h.style.transform="",h.style["-webkit-transform"]="",p=g.style.overflow,d=r.style.overflow,m=r.style.height,f=r.scrollTop,g.style.overflow="visible",r.style.overflow="visible",r.style.height="200%",r.scrollTop=r.scrollHeight,k.elementBCRIgnoresBodyScroll=b.getBoundingClientRect().top!==n.getBoundingClientRect().top,r.scrollTop=f,r.style.height=
m,r.style.overflow=d,g.style.overflow=p,b.detach(),r.removeChild(h),b=Object.keys(k).map(function(c){return c+":"+String(k[c])}).join(", "),runtime.log("Detected browser quirks - "+b)));return k}var k;core.DomUtils=function(){function b(b,c){for(var a=0,e;b.parentNode!==c;)runtime.assert(null!==b.parentNode,"parent is null"),b=b.parentNode;for(e=c.firstChild;e!==b;)a+=1,e=e.nextSibling;return a}function k(b,c){return 0>=b.compareBoundaryPoints(Range.START_TO_START,c)&&0<=b.compareBoundaryPoints(Range.END_TO_END,
c)}function d(b,c){var a=null;b.nodeType===Node.TEXT_NODE&&(0===b.length?(b.parentNode.removeChild(b),c.nodeType===Node.TEXT_NODE&&(a=c)):(c.nodeType===Node.TEXT_NODE&&(b.appendData(c.data),c.parentNode.removeChild(c)),a=b));return a}function h(b){for(var c=b.parentNode;b.firstChild;)c.insertBefore(b.firstChild,b);c.removeChild(b);return c}function n(b,c){for(var a=b.parentNode,e=b.firstChild,l;e;)l=e.nextSibling,n(e,c),e=l;a&&c(b)&&h(b);return a}function q(b,c){return b===c||Boolean(b.compareDocumentPosition(c)&
Node.DOCUMENT_POSITION_CONTAINED_BY)}function r(b,c,a){Object.keys(c).forEach(function(e){var l=e.split(":"),d=l[1],h=a(l[0]),l=c[e],m=typeof l;"object"===m?Object.keys(l).length&&(e=h?b.getElementsByTagNameNS(h,d)[0]||b.ownerDocument.createElementNS(h,e):b.getElementsByTagName(d)[0]||b.ownerDocument.createElement(e),b.appendChild(e),r(e,l,a)):h&&(runtime.assert("number"===m||"string"===m,"attempting to map unsupported type '"+m+"' (key: "+e+")"),b.setAttributeNS(h,e,String(l)))})}var m=null;this.splitBoundaries=
function(f){var c,a=[],e,l,d;if(f.startContainer.nodeType===Node.TEXT_NODE||f.endContainer.nodeType===Node.TEXT_NODE){e=f.endContainer;l=f.endContainer.nodeType!==Node.TEXT_NODE?f.endOffset===f.endContainer.childNodes.length:!1;d=f.endOffset;c=f.endContainer;if(d<c.childNodes.length)for(c=c.childNodes.item(d),d=0;c.firstChild;)c=c.firstChild;else for(;c.lastChild;)c=c.lastChild,d=c.nodeType===Node.TEXT_NODE?c.textContent.length:c.childNodes.length;c===e&&(e=null);f.setEnd(c,d);d=f.endContainer;0!==
f.endOffset&&d.nodeType===Node.TEXT_NODE&&(c=d,f.endOffset!==c.length&&(a.push(c.splitText(f.endOffset)),a.push(c)));d=f.startContainer;0!==f.startOffset&&d.nodeType===Node.TEXT_NODE&&(c=d,f.startOffset!==c.length&&(d=c.splitText(f.startOffset),a.push(c),a.push(d),f.setStart(d,0)));if(null!==e){for(d=f.endContainer;d.parentNode&&d.parentNode!==e;)d=d.parentNode;l=l?e.childNodes.length:b(d,e);f.setEnd(e,l)}}return a};this.containsRange=k;this.rangesIntersect=function(b,c){return 0>=b.compareBoundaryPoints(Range.END_TO_START,
c)&&0<=b.compareBoundaryPoints(Range.START_TO_END,c)};this.getNodesInRange=function(b,c,a){var e=[],l=b.commonAncestorContainer;a=b.startContainer.ownerDocument.createTreeWalker(l.nodeType===Node.TEXT_NODE?l.parentNode:l,a,c,!1);var d;b.endContainer.childNodes[b.endOffset-1]?(l=b.endContainer.childNodes[b.endOffset-1],d=Node.DOCUMENT_POSITION_PRECEDING|Node.DOCUMENT_POSITION_CONTAINED_BY):(l=b.endContainer,d=Node.DOCUMENT_POSITION_PRECEDING);b.startContainer.childNodes[b.startOffset]?(b=b.startContainer.childNodes[b.startOffset],
a.currentNode=b):b.startOffset===(b.startContainer.nodeType===Node.TEXT_NODE?b.startContainer.length:b.startContainer.childNodes.length)?(b=b.startContainer,a.currentNode=b,a.lastChild(),b=a.nextNode()):(b=b.startContainer,a.currentNode=b);b&&c(b)===NodeFilter.FILTER_ACCEPT&&e.push(b);for(b=a.nextNode();b;){c=l.compareDocumentPosition(b);if(0!==c&&0===(c&d))break;e.push(b);b=a.nextNode()}return e};this.normalizeTextNodes=function(b){b&&b.nextSibling&&(b=d(b,b.nextSibling));b&&b.previousSibling&&d(b.previousSibling,
b)};this.rangeContainsNode=function(b,c){var a=c.ownerDocument.createRange(),e=c.ownerDocument.createRange(),l;a.setStart(b.startContainer,b.startOffset);a.setEnd(b.endContainer,b.endOffset);e.selectNodeContents(c);l=k(a,e);a.detach();e.detach();return l};this.mergeIntoParent=h;this.removeUnwantedNodes=n;this.getElementsByTagNameNS=function(b,c,a){var e=[];b=b.getElementsByTagNameNS(c,a);e.length=a=b.length;for(c=0;c<a;c+=1)e[c]=b.item(c);return e};this.containsNode=function(b,c){return b===c||b.contains(c)};
this.comparePoints=function(d,c,a,e){if(d===a)return e-c;var l=d.compareDocumentPosition(a);2===l?l=-1:4===l?l=1:10===l?(c=b(d,a),l=c<e?1:-1):(e=b(a,d),l=e<c?-1:1);return l};this.adaptRangeDifferenceToZoomLevel=function(b,c){return g().unscaledRangeClientRects?b:b/c};this.getBoundingClientRect=function(b){var c=b.ownerDocument,a=g(),e=c.body;if((!1===a.unscaledRangeClientRects||a.rangeBCRIgnoresElementBCR)&&b.nodeType===Node.ELEMENT_NODE)return b=b.getBoundingClientRect(),a.elementBCRIgnoresBodyScroll?
{left:b.left+e.scrollLeft,right:b.right+e.scrollLeft,top:b.top+e.scrollTop,bottom:b.bottom+e.scrollTop}:b;var l;m?l=m:m=l=c.createRange();a=l;a.selectNode(b);return a.getBoundingClientRect()};this.mapKeyValObjOntoNode=function(b,c,a){Object.keys(c).forEach(function(e){var l=e.split(":"),d=l[1],l=a(l[0]),h=c[e];l?(d=b.getElementsByTagNameNS(l,d)[0],d||(d=b.ownerDocument.createElementNS(l,e),b.appendChild(d)),d.textContent=h):runtime.log("Key ignored: "+e)})};this.removeKeyElementsFromNode=function(b,
c,a){c.forEach(function(c){var l=c.split(":"),d=l[1];(l=a(l[0]))?(d=b.getElementsByTagNameNS(l,d)[0])?d.parentNode.removeChild(d):runtime.log("Element for "+c+" not found."):runtime.log("Property Name ignored: "+c)})};this.getKeyValRepresentationOfNode=function(b,c){for(var a={},e=b.firstElementChild,l;e;){if(l=c(e.namespaceURI))a[l+":"+e.localName]=e.textContent;e=e.nextElementSibling}return a};this.mapObjOntoNode=r;(function(b){var c,a;a=runtime.getWindow();null!==a&&(c=a.navigator.appVersion.toLowerCase(),
a=-1===c.indexOf("chrome")&&(-1!==c.indexOf("applewebkit")||-1!==c.indexOf("safari")),c=c.indexOf("msie"),a||c)&&(b.containsNode=q)})(this)};return core.DomUtils})();
// Input 8
core.Cursor=function(g,k){function b(c){c.parentNode&&(q.push(c.previousSibling),q.push(c.nextSibling),c.parentNode.removeChild(c))}function p(c,a,b){if(a.nodeType===Node.TEXT_NODE){runtime.assert(Boolean(a),"putCursorIntoTextNode: invalid container");var l=a.parentNode;runtime.assert(Boolean(l),"putCursorIntoTextNode: container without parent");runtime.assert(0<=b&&b<=a.length,"putCursorIntoTextNode: offset is out of bounds");0===b?l.insertBefore(c,a):(b!==a.length&&a.splitText(b),l.insertBefore(c,
a.nextSibling))}else a.nodeType===Node.ELEMENT_NODE&&a.insertBefore(c,a.childNodes.item(b));q.push(c.previousSibling);q.push(c.nextSibling)}var d=g.createElementNS("urn:webodf:names:cursor","cursor"),h=g.createElementNS("urn:webodf:names:cursor","anchor"),n,q=[],r=g.createRange(),m,f=new core.DomUtils;this.getNode=function(){return d};this.getAnchorNode=function(){return h.parentNode?h:d};this.getSelectedRange=function(){m?(r.setStartBefore(d),r.collapse(!0)):(r.setStartAfter(n?h:d),r.setEndBefore(n?
d:h));return r};this.setSelectedRange=function(c,a){r&&r!==c&&r.detach();r=c;n=!1!==a;(m=c.collapsed)?(b(h),b(d),p(d,c.startContainer,c.startOffset)):(b(h),b(d),p(n?d:h,c.endContainer,c.endOffset),p(n?h:d,c.startContainer,c.startOffset));q.forEach(f.normalizeTextNodes);q.length=0};this.hasForwardSelection=function(){return n};this.remove=function(){b(d);q.forEach(f.normalizeTextNodes);q.length=0};d.setAttributeNS("urn:webodf:names:cursor","memberId",k);h.setAttributeNS("urn:webodf:names:cursor","memberId",
k)};
// Input 9
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
core.Destroyable=function(){};core.Destroyable.prototype.destroy=function(g){};
// Input 10
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
core.EventNotifier=function(g){var k={};this.emit=function(b,g){var d,h;runtime.assert(k.hasOwnProperty(b),'unknown event fired "'+b+'"');h=k[b];for(d=0;d<h.length;d+=1)h[d](g)};this.subscribe=function(b,g){runtime.assert(k.hasOwnProperty(b),'tried to subscribe to unknown event "'+b+'"');k[b].push(g)};this.unsubscribe=function(b,g){var d;runtime.assert(k.hasOwnProperty(b),'tried to unsubscribe from unknown event "'+b+'"');d=k[b].indexOf(g);runtime.assert(-1!==d,'tried to unsubscribe unknown callback from event "'+
b+'"');-1!==d&&k[b].splice(d,1)};(function(){var b,p;for(b=0;b<g.length;b+=1)p=g[b],runtime.assert(!k.hasOwnProperty(p),'Duplicated event ids: "'+p+'" registered more than once.'),k[p]=[]})()};
// Input 11
/*

 Copyright (C) 2012 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
core.LoopWatchDog=function(g,k){var b=Date.now(),p=0;this.check=function(){var d;if(g&&(d=Date.now(),d-b>g))throw runtime.log("alert","watchdog timeout"),"timeout!";if(0<k&&(p+=1,p>k))throw runtime.log("alert","watchdog loop overflow"),"loop overflow";}};
// Input 12
core.PositionIterator=function(g,k,b,p){function d(){this.acceptNode=function(a){return!a||a.nodeType===e&&0===a.length?t:s}}function h(a){this.acceptNode=function(c){return!c||c.nodeType===e&&0===c.length?t:a.acceptNode(c)}}function n(){var a=f.currentNode,b=a.nodeType;c=b===e?a.length-1:b===l?1:0}function q(){if(null===f.previousSibling()){if(!f.parentNode()||f.currentNode===g)return f.firstChild(),!1;c=0}else n();return!0}function r(){var b=f.currentNode,e;e=a(b);if(b!==g)for(b=b.parentNode;b&&
b!==g;)a(b)===t&&(f.currentNode=b,e=t),b=b.parentNode;e===t?(c=1,b=m.nextPosition()):b=e===s?!0:m.nextPosition();b&&runtime.assert(a(f.currentNode)===s,"moveToAcceptedNode did not result in walker being on an accepted node");return b}var m=this,f,c,a,e=Node.TEXT_NODE,l=Node.ELEMENT_NODE,s=NodeFilter.FILTER_ACCEPT,t=NodeFilter.FILTER_REJECT;this.nextPosition=function(){var a=f.currentNode,b=a.nodeType;if(a===g)return!1;if(0===c&&b===l)null===f.firstChild()&&(c=1);else if(b===e&&c+1<a.length)c+=1;else if(null!==
f.nextSibling())c=0;else if(f.parentNode())c=1;else return!1;return!0};this.previousPosition=function(){var a=!0,b=f.currentNode;0===c?a=q():b.nodeType===e?c-=1:null!==f.lastChild()?n():b===g?a=!1:c=0;return a};this.previousNode=q;this.container=function(){var a=f.currentNode,b=a.nodeType;0===c&&b!==e&&(a=a.parentNode);return a};this.rightNode=function(){var b=f.currentNode,d=b.nodeType;if(d===e&&c===b.length)for(b=b.nextSibling;b&&a(b)!==s;)b=b.nextSibling;else d===l&&1===c&&(b=null);return b};this.leftNode=
function(){var b=f.currentNode;if(0===c)for(b=b.previousSibling;b&&a(b)!==s;)b=b.previousSibling;else if(b.nodeType===l)for(b=b.lastChild;b&&a(b)!==s;)b=b.previousSibling;return b};this.getCurrentNode=function(){return f.currentNode};this.unfilteredDomOffset=function(){if(f.currentNode.nodeType===e)return c;for(var a=0,b=f.currentNode,b=1===c?b.lastChild:b.previousSibling;b;)a+=1,b=b.previousSibling;return a};this.getPreviousSibling=function(){var a=f.currentNode,c=f.previousSibling();f.currentNode=
a;return c};this.getNextSibling=function(){var a=f.currentNode,c=f.nextSibling();f.currentNode=a;return c};this.setPositionBeforeElement=function(a){runtime.assert(Boolean(a),"setPositionBeforeElement called without element");f.currentNode=a;c=0;return r()};this.setUnfilteredPosition=function(a,b){runtime.assert(Boolean(a),"PositionIterator.setUnfilteredPosition called without container");f.currentNode=a;if(a.nodeType===e)return c=b,runtime.assert(b<=a.length,"Error in setPosition: "+b+" > "+a.length),
runtime.assert(0<=b,"Error in setPosition: "+b+" < 0"),b===a.length&&(f.nextSibling()?c=0:f.parentNode()?c=1:runtime.assert(!1,"Error in setUnfilteredPosition: position not valid.")),!0;b<a.childNodes.length?(f.currentNode=a.childNodes.item(b),c=0):c=1;return r()};this.moveToEnd=function(){f.currentNode=g;c=1};this.moveToEndOfNode=function(a){a.nodeType===e?m.setUnfilteredPosition(a,a.length):(f.currentNode=a,c=1)};this.isBeforeNode=function(){return 0===c};this.getNodeFilter=function(){return a};
a=(b?new h(b):new d).acceptNode;a.acceptNode=a;k=k||NodeFilter.SHOW_ALL;runtime.assert(g.nodeType!==Node.TEXT_NODE,"Internet Explorer doesn't allow tree walker roots to be text nodes");f=g.ownerDocument.createTreeWalker(g,k,a,p);c=0;null===f.firstChild()&&(c=1)};
// Input 13
core.PositionFilter=function(){};core.PositionFilter.FilterResult={FILTER_ACCEPT:1,FILTER_REJECT:2,FILTER_SKIP:3};core.PositionFilter.prototype.acceptPosition=function(g){};(function(){return core.PositionFilter})();
// Input 14
core.PositionFilterChain=function(){var g=[],k=core.PositionFilter.FilterResult.FILTER_ACCEPT,b=core.PositionFilter.FilterResult.FILTER_REJECT;this.acceptPosition=function(p){var d;for(d=0;d<g.length;d+=1)if(g[d].acceptPosition(p)===b)return b;return k};this.addFilter=function(b){g.push(b)}};
// Input 15
core.zip_HuftNode=function(){this.n=this.b=this.e=0;this.t=null};core.zip_HuftList=function(){this.list=this.next=null};
core.RawInflate=function(){function g(a,c,b,e,l,d){this.BMAX=16;this.N_MAX=288;this.status=0;this.root=null;this.m=0;var f=Array(this.BMAX+1),h,m,k,n,g,w,p,q=Array(this.BMAX+1),s,r,x,t=new core.zip_HuftNode,H=Array(this.BMAX);n=Array(this.N_MAX);var F,u=Array(this.BMAX+1),y,D,v;v=this.root=null;for(g=0;g<f.length;g++)f[g]=0;for(g=0;g<q.length;g++)q[g]=0;for(g=0;g<H.length;g++)H[g]=null;for(g=0;g<n.length;g++)n[g]=0;for(g=0;g<u.length;g++)u[g]=0;h=256<c?a[256]:this.BMAX;s=a;r=0;g=c;do f[s[r]]++,r++;
while(0<--g);if(f[0]===c)this.root=null,this.status=this.m=0;else{for(w=1;w<=this.BMAX&&0===f[w];w++);p=w;d<w&&(d=w);for(g=this.BMAX;0!==g&&0===f[g];g--);k=g;d>g&&(d=g);for(y=1<<w;w<g;w++,y<<=1)if(y-=f[w],0>y){this.status=2;this.m=d;return}y-=f[g];if(0>y)this.status=2,this.m=d;else{f[g]+=y;u[1]=w=0;s=f;r=1;for(x=2;0<--g;)w+=s[r++],u[x++]=w;s=a;g=r=0;do w=s[r++],0!==w&&(n[u[w]++]=g);while(++g<c);c=u[k];u[0]=g=0;s=n;r=0;n=-1;F=q[0]=0;x=null;D=0;for(p=p-1+1;p<=k;p++)for(a=f[p];0<a--;){for(;p>F+q[1+n];){F+=
q[1+n];n++;D=k-F;D=D>d?d:D;w=p-F;m=1<<w;if(m>a+1)for(m-=a+1,x=p;++w<D;){m<<=1;if(m<=f[++x])break;m-=f[x]}F+w>h&&F<h&&(w=h-F);D=1<<w;q[1+n]=w;x=Array(D);for(m=0;m<D;m++)x[m]=new core.zip_HuftNode;v=null===v?this.root=new core.zip_HuftList:v.next=new core.zip_HuftList;v.next=null;v.list=x;H[n]=x;0<n&&(u[n]=g,t.b=q[n],t.e=16+w,t.t=x,w=(g&(1<<F)-1)>>F-q[n],H[n-1][w].e=t.e,H[n-1][w].b=t.b,H[n-1][w].n=t.n,H[n-1][w].t=t.t)}t.b=p-F;r>=c?t.e=99:s[r]<b?(t.e=256>s[r]?16:15,t.n=s[r++]):(t.e=l[s[r]-b],t.n=e[s[r++]-
b]);m=1<<p-F;for(w=g>>F;w<D;w+=m)x[w].e=t.e,x[w].b=t.b,x[w].n=t.n,x[w].t=t.t;for(w=1<<p-1;0!==(g&w);w>>=1)g^=w;for(g^=w;(g&(1<<F)-1)!==u[n];)F-=q[n],n--}this.m=q[1];this.status=0!==y&&1!==k?1:0}}}function k(b){for(;a<b;){var e=c,l;l=u.length===w?-1:u[w++];c=e|l<<a;a+=8}}function b(a){return c&x[a]}function p(b){c>>=b;a-=b}function d(a,c,l){var d,f,h;if(0===l)return 0;for(h=0;;){k(D);f=y.list[b(D)];for(d=f.e;16<d;){if(99===d)return-1;p(f.b);d-=16;k(d);f=f.t[b(d)];d=f.e}p(f.b);if(16===d)q&=32767,a[c+
h++]=n[q++]=f.n;else{if(15===d)break;k(d);s=f.n+b(d);p(d);k(v);f=B.list[b(v)];for(d=f.e;16<d;){if(99===d)return-1;p(f.b);d-=16;k(d);f=f.t[b(d)];d=f.e}p(f.b);k(d);t=q-f.n-b(d);for(p(d);0<s&&h<l;)s--,t&=32767,q&=32767,a[c+h++]=n[q++]=n[t++]}if(h===l)return l}e=-1;return h}function h(a,c,e){var l,f,h,m,w,n,q,s=Array(316);for(l=0;l<s.length;l++)s[l]=0;k(5);n=257+b(5);p(5);k(5);q=1+b(5);p(5);k(4);l=4+b(4);p(4);if(286<n||30<q)return-1;for(f=0;f<l;f++)k(3),s[F[f]]=b(3),p(3);for(f=l;19>f;f++)s[F[f]]=0;D=
7;f=new g(s,19,19,null,null,D);if(0!==f.status)return-1;y=f.root;D=f.m;m=n+q;for(l=h=0;l<m;)if(k(D),w=y.list[b(D)],f=w.b,p(f),f=w.n,16>f)s[l++]=h=f;else if(16===f){k(2);f=3+b(2);p(2);if(l+f>m)return-1;for(;0<f--;)s[l++]=h}else{17===f?(k(3),f=3+b(3),p(3)):(k(7),f=11+b(7),p(7));if(l+f>m)return-1;for(;0<f--;)s[l++]=0;h=0}D=9;f=new g(s,n,257,U,E,D);0===D&&(f.status=1);if(0!==f.status)return-1;y=f.root;D=f.m;for(l=0;l<q;l++)s[l]=s[l+n];v=6;f=new g(s,q,0,H,T,v);B=f.root;v=f.m;return 0===v&&257<n||0!==f.status?
-1:d(a,c,e)}var n=[],q,r=null,m,f,c,a,e,l,s,t,y,B,D,v,u,w,x=[0,1,3,7,15,31,63,127,255,511,1023,2047,4095,8191,16383,32767,65535],U=[3,4,5,6,7,8,9,10,11,13,15,17,19,23,27,31,35,43,51,59,67,83,99,115,131,163,195,227,258,0,0],E=[0,0,0,0,0,0,0,0,1,1,1,1,2,2,2,2,3,3,3,3,4,4,4,4,5,5,5,5,0,99,99],H=[1,2,3,4,5,7,9,13,17,25,33,49,65,97,129,193,257,385,513,769,1025,1537,2049,3073,4097,6145,8193,12289,16385,24577],T=[0,0,0,0,1,1,2,2,3,3,4,4,5,5,6,6,7,7,8,8,9,9,10,10,11,11,12,12,13,13],F=[16,17,18,0,8,7,9,6,
10,5,11,4,12,3,13,2,14,1,15],Z;this.inflate=function(x,F){n.length=65536;a=c=q=0;e=-1;l=!1;s=t=0;y=null;u=x;w=0;var G=new Uint8Array(new ArrayBuffer(F));a:for(var R=0,z;R<F&&(!l||-1!==e);){if(0<s){if(0!==e)for(;0<s&&R<F;)s--,t&=32767,q&=32767,G[0+R]=n[q]=n[t],R+=1,q+=1,t+=1;else{for(;0<s&&R<F;)s-=1,q&=32767,k(8),G[0+R]=n[q]=b(8),R+=1,q+=1,p(8);0===s&&(e=-1)}if(R===F)break}if(-1===e){if(l)break;k(1);0!==b(1)&&(l=!0);p(1);k(2);e=b(2);p(2);y=null;s=0}switch(e){case 0:z=G;var fa=0+R,ea=F-R,L=void 0,L=
a&7;p(L);k(16);L=b(16);p(16);k(16);if(L!==(~c&65535))z=-1;else{p(16);s=L;for(L=0;0<s&&L<ea;)s--,q&=32767,k(8),z[fa+L++]=n[q++]=b(8),p(8);0===s&&(e=-1);z=L}break;case 1:if(null!==y)z=d(G,0+R,F-R);else b:{z=G;fa=0+R;ea=F-R;if(null===r){for(var K=void 0,L=Array(288),K=void 0,K=0;144>K;K++)L[K]=8;for(K=144;256>K;K++)L[K]=9;for(K=256;280>K;K++)L[K]=7;for(K=280;288>K;K++)L[K]=8;f=7;K=new g(L,288,257,U,E,f);if(0!==K.status){alert("HufBuild error: "+K.status);z=-1;break b}r=K.root;f=K.m;for(K=0;30>K;K++)L[K]=
5;Z=5;K=new g(L,30,0,H,T,Z);if(1<K.status){r=null;alert("HufBuild error: "+K.status);z=-1;break b}m=K.root;Z=K.m}y=r;B=m;D=f;v=Z;z=d(z,fa,ea)}break;case 2:z=null!==y?d(G,0+R,F-R):h(G,0+R,F-R);break;default:z=-1}if(-1===z)break a;R+=z}u=new Uint8Array(new ArrayBuffer(0));return G}};
// Input 16
core.ScheduledTask=function(g,k){function b(){h&&(runtime.clearTimeout(d),h=!1)}function p(){b();g.apply(void 0,n);n=null}var d,h=!1,n=[];this.trigger=function(){n=Array.prototype.slice.call(arguments);h||(h=!0,d=runtime.setTimeout(p,k))};this.triggerImmediate=function(){n=Array.prototype.slice.call(arguments);p()};this.processRequests=function(){h&&p()};this.cancel=b;this.destroy=function(d){b();d()}};
// Input 17
/*

 Copyright (C) 2014 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
core.StepIterator=function(g,k){function b(){f=null;a=c=void 0}function p(){void 0===a&&(a=g.acceptPosition(k)===m);return a}function d(a,c){b();return k.setUnfilteredPosition(a,c)}function h(){f||(f=k.container());return f}function n(){void 0===c&&(c=k.unfilteredDomOffset());return c}function q(){for(b();k.nextPosition();)if(b(),p())return!0;return!1}function r(){for(b();k.previousPosition();)if(b(),p())return!0;return!1}var m=core.PositionFilter.FilterResult.FILTER_ACCEPT,f,c,a;this.isStep=p;this.setPosition=
d;this.container=h;this.offset=n;this.nextStep=q;this.previousStep=r;this.roundToClosestStep=function(){var a=h(),c=n(),b=p();b||(b=r(),b||(d(a,c),b=q()));return b};this.roundToPreviousStep=function(){var a=p();a||(a=r());return a};this.roundToNextStep=function(){var a=p();a||(a=q());return a}};
// Input 18
core.UnitTest=function(){};core.UnitTest.prototype.setUp=function(){};core.UnitTest.prototype.tearDown=function(){};core.UnitTest.prototype.description=function(){};core.UnitTest.prototype.tests=function(){};core.UnitTest.prototype.asyncTests=function(){};
core.UnitTest.provideTestAreaDiv=function(){var g=runtime.getWindow().document,k=g.getElementById("testarea");runtime.assert(!k,'Unclean test environment, found a div with id "testarea".');k=g.createElement("div");k.setAttribute("id","testarea");g.body.appendChild(k);return k};
core.UnitTest.cleanupTestAreaDiv=function(){var g=runtime.getWindow().document,k=g.getElementById("testarea");runtime.assert(!!k&&k.parentNode===g.body,'Test environment broken, found no div with id "testarea" below body.');g.body.removeChild(k)};core.UnitTest.createOdtDocument=function(g,k){var b="<?xml version='1.0' encoding='UTF-8'?>",b=b+"<office:document";Object.keys(k).forEach(function(g){b+=" xmlns:"+g+'="'+k[g]+'"'});b+=">";b+=g;b+="</office:document>";return runtime.parseXML(b)};
core.UnitTestLogger=function(){var g=[],k=0,b=0,p="",d="";this.startTest=function(h,n){g=[];k=0;p=h;d=n;b=(new Date).getTime()};this.endTest=function(){var h=(new Date).getTime();return{description:d,suite:[p,d],success:0===k,log:g,time:h-b}};this.debug=function(b){g.push({category:"debug",message:b})};this.fail=function(b){k+=1;g.push({category:"fail",message:b})};this.pass=function(b){g.push({category:"pass",message:b})}};
core.UnitTestRunner=function(g,k){function b(a){r+=1;c?k.debug(a):k.fail(a)}function p(a,c){var l;try{if(a.length!==c.length)return b("array of length "+a.length+" should be "+c.length+" long"),!1;for(l=0;l<a.length;l+=1)if(a[l]!==c[l])return b(a[l]+" should be "+c[l]+" at array index "+l),!1}catch(d){return!1}return!0}function d(a,c,l){var f=a.attributes,h=f.length,m,g,n;for(m=0;m<h;m+=1)if(g=f.item(m),"xmlns"!==g.prefix&&"urn:webodf:names:steps"!==g.namespaceURI){n=c.getAttributeNS(g.namespaceURI,
g.localName);if(!c.hasAttributeNS(g.namespaceURI,g.localName))return b("Attribute "+g.localName+" with value "+g.value+" was not present"),!1;if(n!==g.value)return b("Attribute "+g.localName+" was "+n+" should be "+g.value),!1}return l?!0:d(c,a,!0)}function h(a,c){var l,f;l=a.nodeType;f=c.nodeType;if(l!==f)return b("Nodetype '"+l+"' should be '"+f+"'"),!1;if(l===Node.TEXT_NODE){if(a.data===c.data)return!0;b("Textnode data '"+a.data+"' should be '"+c.data+"'");return!1}runtime.assert(l===Node.ELEMENT_NODE,
"Only textnodes and elements supported.");if(a.namespaceURI!==c.namespaceURI)return b("namespace '"+a.namespaceURI+"' should be '"+c.namespaceURI+"'"),!1;if(a.localName!==c.localName)return b("localName '"+a.localName+"' should be '"+c.localName+"'"),!1;if(!d(a,c,!1))return!1;l=a.firstChild;for(f=c.firstChild;l;){if(!f)return b("Nodetype '"+l.nodeType+"' is unexpected here."),!1;if(!h(l,f))return!1;l=l.nextSibling;f=f.nextSibling}return f?(b("Nodetype '"+f.nodeType+"' is missing here."),!1):!0}function n(a,
c){return 0===c?a===c&&1/a===1/c:a===c?!0:null===a||null===c?!1:"number"===typeof c&&isNaN(c)?"number"===typeof a&&isNaN(a):Object.prototype.toString.call(c)===Object.prototype.toString.call([])?p(a,c):"object"===typeof c&&"object"===typeof a?c.constructor===Element||c.constructor===Node?h(a,c):f(a,c):!1}function q(a,c,l){"string"===typeof c&&"string"===typeof l||k.debug("WARN: shouldBe() expects string arguments");var d,f;try{f=eval(c)}catch(h){d=h}a=eval(l);d?b(c+" should be "+a+". Threw exception "+
d):n(f,a)?k.pass(c+" is "+l):String(typeof f)===String(typeof a)?(l=0===f&&0>1/f?"-0":String(f),b(c+" should be "+a+". Was "+l+".")):b(c+" should be "+a+" (of type "+typeof a+"). Was "+f+" (of type "+typeof f+").")}var r=0,m,f,c=!1;this.resourcePrefix=function(){return g};this.beginExpectFail=function(){m=r;c=!0};this.endExpectFail=function(){var a=m===r;c=!1;r=m;a&&(r+=1,k.fail("Expected at least one failed test, but none registered."))};f=function(a,c){var l=Object.keys(a),d=Object.keys(c);l.sort();
d.sort();return p(l,d)&&Object.keys(a).every(function(l){var d=a[l],f=c[l];return n(d,f)?!0:(b(d+" should be "+f+" for key "+l),!1)})};this.areNodesEqual=h;this.shouldBeNull=function(a,c){q(a,c,"null")};this.shouldBeNonNull=function(a,c){var l,d;try{d=eval(c)}catch(f){l=f}l?b(c+" should be non-null. Threw exception "+l):null!==d?k.pass(c+" is non-null."):b(c+" should be non-null. Was "+d)};this.shouldBe=q;this.testFailed=b;this.countFailedTests=function(){return r};this.name=function(a){var c,b,d=
[],f=a.length;d.length=f;for(c=0;c<f;c+=1){b=Runtime.getFunctionName(a[c])||"";if(""===b)throw"Found a function without a name.";d[c]={f:a[c],name:b}}return d}};
core.UnitTester=function(){function g(b,d){return"<span style='color:blue;cursor:pointer' onclick='"+d+"'>"+b+"</span>"}function k(d){b.reporter&&b.reporter(d)}var b=this,p=0,d=new core.UnitTestLogger,h={},n="BrowserRuntime"===runtime.type();this.resourcePrefix="";this.reporter=function(b){var d,h;n?runtime.log("<span>Running "+g(b.description,'runTest("'+b.suite[0]+'","'+b.description+'")')+"</span>"):runtime.log("Running "+b.description);if(!b.success)for(d=0;d<b.log.length;d+=1)h=b.log[d],runtime.log(h.category,
h.message)};this.runTests=function(q,r,m){function f(b){if(0===b.length)h[c]=l,p+=a.countFailedTests(),r();else{t=b[0].f;var g=b[0].name,n=!0===b[0].expectFail;D=a.countFailedTests();m.length&&-1===m.indexOf(g)?f(b.slice(1)):(e.setUp(),d.startTest(c,g),n&&a.beginExpectFail(),t(function(){n&&a.endExpectFail();k(d.endTest());e.tearDown();l[g]=D===a.countFailedTests();f(b.slice(1))}))}}var c=Runtime.getFunctionName(q)||"",a=new core.UnitTestRunner(b.resourcePrefix,d),e=new q(a),l={},s,t,y,B,D;if(h.hasOwnProperty(c))runtime.log("Test "+
c+" has already run.");else{n?runtime.log("<span>Running "+g(c,'runSuite("'+c+'");')+": "+e.description()+"</span>"):runtime.log("Running "+c+": "+e.description);y=e.tests();for(s=0;s<y.length;s+=1)if(t=y[s].f,q=y[s].name,B=!0===y[s].expectFail,!m.length||-1!==m.indexOf(q)){D=a.countFailedTests();e.setUp();d.startTest(c,q);B&&a.beginExpectFail();try{t()}catch(v){a.testFailed("Unexpected exception encountered: "+v.toString())}B&&a.endExpectFail();k(d.endTest());e.tearDown();l[q]=D===a.countFailedTests()}f(e.asyncTests())}};
this.countFailedTests=function(){return p};this.results=function(){return h}};
// Input 19
core.Utils=function(){function g(k,b){if(b&&Array.isArray(b)){k=k||[];if(!Array.isArray(k))throw"Destination is not an array.";k=k.concat(b.map(function(b){return g(null,b)}))}else if(b&&"object"===typeof b){k=k||{};if("object"!==typeof k)throw"Destination is not an object.";Object.keys(b).forEach(function(p){k[p]=g(k[p],b[p])})}else k=b;return k}this.hashString=function(g){var b=0,p,d;p=0;for(d=g.length;p<d;p+=1)b=(b<<5)-b+g.charCodeAt(p),b|=0;return b};this.mergeObjects=function(k,b){Object.keys(b).forEach(function(p){k[p]=
g(k[p],b[p])});return k}};
// Input 20
/*

 WebODF
 Copyright (c) 2010 Jos van den Oever
 Licensed under the ... License:

 Project home: http://www.webodf.org/
*/
core.Zip=function(g,k){function b(a){var c=[0,1996959894,3993919788,2567524794,124634137,1886057615,3915621685,2657392035,249268274,2044508324,3772115230,2547177864,162941995,2125561021,3887607047,2428444049,498536548,1789927666,4089016648,2227061214,450548861,1843258603,4107580753,2211677639,325883990,1684777152,4251122042,2321926636,335633487,1661365465,4195302755,2366115317,997073096,1281953886,3579855332,2724688242,1006888145,1258607687,3524101629,2768942443,901097722,1119000684,3686517206,2898065728,
853044451,1172266101,3705015759,2882616665,651767980,1373503546,3369554304,3218104598,565507253,1454621731,3485111705,3099436303,671266974,1594198024,3322730930,2970347812,795835527,1483230225,3244367275,3060149565,1994146192,31158534,2563907772,4023717930,1907459465,112637215,2680153253,3904427059,2013776290,251722036,2517215374,3775830040,2137656763,141376813,2439277719,3865271297,1802195444,476864866,2238001368,4066508878,1812370925,453092731,2181625025,4111451223,1706088902,314042704,2344532202,
4240017532,1658658271,366619977,2362670323,4224994405,1303535960,984961486,2747007092,3569037538,1256170817,1037604311,2765210733,3554079995,1131014506,879679996,2909243462,3663771856,1141124467,855842277,2852801631,3708648649,1342533948,654459306,3188396048,3373015174,1466479909,544179635,3110523913,3462522015,1591671054,702138776,2966460450,3352799412,1504918807,783551873,3082640443,3233442989,3988292384,2596254646,62317068,1957810842,3939845945,2647816111,81470997,1943803523,3814918930,2489596804,
225274430,2053790376,3826175755,2466906013,167816743,2097651377,4027552580,2265490386,503444072,1762050814,4150417245,2154129355,426522225,1852507879,4275313526,2312317920,282753626,1742555852,4189708143,2394877945,397917763,1622183637,3604390888,2714866558,953729732,1340076626,3518719985,2797360999,1068828381,1219638859,3624741850,2936675148,906185462,1090812512,3747672003,2825379669,829329135,1181335161,3412177804,3160834842,628085408,1382605366,3423369109,3138078467,570562233,1426400815,3317316542,
2998733608,733239954,1555261956,3268935591,3050360625,752459403,1541320221,2607071920,3965973030,1969922972,40735498,2617837225,3943577151,1913087877,83908371,2512341634,3803740692,2075208622,213261112,2463272603,3855990285,2094854071,198958881,2262029012,4057260610,1759359992,534414190,2176718541,4139329115,1873836001,414664567,2282248934,4279200368,1711684554,285281116,2405801727,4167216745,1634467795,376229701,2685067896,3608007406,1308918612,956543938,2808555105,3495958263,1231636301,1047427035,
2932959818,3654703836,1088359270,936918E3,2847714899,3736837829,1202900863,817233897,3183342108,3401237130,1404277552,615818150,3134207493,3453421203,1423857449,601450431,3009837614,3294710456,1567103746,711928724,3020668471,3272380065,1510334235,755167117],b,e,d=a.length,l=0,l=0;b=-1;for(e=0;e<d;e+=1)l=(b^a[e])&255,l=c[l],b=b>>>8^l;return b^-1}function p(a){return new Date((a>>25&127)+1980,(a>>21&15)-1,a>>16&31,a>>11&15,a>>5&63,(a&31)<<1)}function d(a){var c=a.getFullYear();return 1980>c?0:c-1980<<
25|a.getMonth()+1<<21|a.getDate()<<16|a.getHours()<<11|a.getMinutes()<<5|a.getSeconds()>>1}function h(a,c){var b,e,d,f,h,g,m,n=this;this.load=function(c){if(null!==n.data)c(null,n.data);else{var b=h+34+e+d+256;b+m>l&&(b=l-m);runtime.read(a,m,b,function(b,e){if(b||null===e)c(b,e);else a:{var d=e,l=new core.ByteArray(d),m=l.readUInt32LE(),w;if(67324752!==m)c("File entry signature is wrong."+m.toString()+" "+d.length.toString(),null);else{l.pos+=22;m=l.readUInt16LE();w=l.readUInt16LE();l.pos+=m+w;if(f){d=
d.subarray(l.pos,l.pos+h);if(h!==d.length){c("The amount of compressed bytes read was "+d.length.toString()+" instead of "+h.toString()+" for "+n.filename+" in "+a+".",null);break a}d=t(d,g)}else d=d.subarray(l.pos,l.pos+g);g!==d.length?c("The amount of bytes read was "+d.length.toString()+" instead of "+g.toString()+" for "+n.filename+" in "+a+".",null):(n.data=d,c(null,d))}}})}};this.set=function(a,c,b,e){n.filename=a;n.data=c;n.compressed=b;n.date=e};this.error=null;c&&(b=c.readUInt32LE(),33639248!==
b?this.error="Central directory entry has wrong signature at position "+(c.pos-4).toString()+' for file "'+a+'": '+c.data.length.toString():(c.pos+=6,f=c.readUInt16LE(),this.date=p(c.readUInt32LE()),c.readUInt32LE(),h=c.readUInt32LE(),g=c.readUInt32LE(),e=c.readUInt16LE(),d=c.readUInt16LE(),b=c.readUInt16LE(),c.pos+=8,m=c.readUInt32LE(),this.filename=runtime.byteArrayToString(c.data.subarray(c.pos,c.pos+e),"utf8"),this.data=null,c.pos+=e+d+b))}function n(a,c){if(22!==a.length)c("Central directory length should be 22.",
y);else{var b=new core.ByteArray(a),d;d=b.readUInt32LE();101010256!==d?c("Central directory signature is wrong: "+d.toString(),y):(d=b.readUInt16LE(),0!==d?c("Zip files with non-zero disk numbers are not supported.",y):(d=b.readUInt16LE(),0!==d?c("Zip files with non-zero disk numbers are not supported.",y):(d=b.readUInt16LE(),s=b.readUInt16LE(),d!==s?c("Number of entries is inconsistent.",y):(d=b.readUInt32LE(),b=b.readUInt16LE(),b=l-22-d,runtime.read(g,b,l-b,function(a,b){if(a||null===b)c(a,y);else a:{var d=
new core.ByteArray(b),l,f;e=[];for(l=0;l<s;l+=1){f=new h(g,d);if(f.error){c(f.error,y);break a}e[e.length]=f}c(null,y)}})))))}}function q(a,c){var b=null,d,l;for(l=0;l<e.length;l+=1)if(d=e[l],d.filename===a){b=d;break}b?b.data?c(null,b.data):b.load(c):c(a+" not found.",null)}function r(a){var c=new core.ByteArrayWriter("utf8"),e=0;c.appendArray([80,75,3,4,20,0,0,0,0,0]);a.data&&(e=a.data.length);c.appendUInt32LE(d(a.date));c.appendUInt32LE(a.data?b(a.data):0);c.appendUInt32LE(e);c.appendUInt32LE(e);
c.appendUInt16LE(a.filename.length);c.appendUInt16LE(0);c.appendString(a.filename);a.data&&c.appendByteArray(a.data);return c}function m(a,c){var e=new core.ByteArrayWriter("utf8"),l=0;e.appendArray([80,75,1,2,20,0,20,0,0,0,0,0]);a.data&&(l=a.data.length);e.appendUInt32LE(d(a.date));e.appendUInt32LE(a.data?b(a.data):0);e.appendUInt32LE(l);e.appendUInt32LE(l);e.appendUInt16LE(a.filename.length);e.appendArray([0,0,0,0,0,0,0,0,0,0,0,0]);e.appendUInt32LE(c);e.appendString(a.filename);return e}function f(a,
c){if(a===e.length)c(null);else{var b=e[a];null!==b.data?f(a+1,c):b.load(function(b){b?c(b):f(a+1,c)})}}function c(a,c){f(0,function(b){if(b)c(b);else{var d,l,f=new core.ByteArrayWriter("utf8"),h=[0];for(d=0;d<e.length;d+=1)f.appendByteArrayWriter(r(e[d])),h.push(f.getLength());b=f.getLength();for(d=0;d<e.length;d+=1)l=e[d],f.appendByteArrayWriter(m(l,h[d]));d=f.getLength()-b;f.appendArray([80,75,5,6,0,0,0,0]);f.appendUInt16LE(e.length);f.appendUInt16LE(e.length);f.appendUInt32LE(d);f.appendUInt32LE(b);
f.appendArray([0,0]);a(f.getByteArray())}})}function a(a,b){c(function(c){runtime.writeFile(a,c,b)},b)}var e,l,s,t=(new core.RawInflate).inflate,y=this,B=new core.Base64;this.load=q;this.save=function(a,c,b,d){var l,f;for(l=0;l<e.length;l+=1)if(f=e[l],f.filename===a){f.set(a,c,b,d);return}f=new h(g);f.set(a,c,b,d);e.push(f)};this.remove=function(a){var c,b;for(c=0;c<e.length;c+=1)if(b=e[c],b.filename===a)return e.splice(c,1),!0;return!1};this.write=function(c){a(g,c)};this.writeAs=a;this.createByteArray=
c;this.loadContentXmlAsFragments=function(a,c){y.loadAsString(a,function(a,b){if(a)return c.rootElementReady(a);c.rootElementReady(null,b,!0)})};this.loadAsString=function(a,c){q(a,function(a,b){if(a||null===b)return c(a,null);var e=runtime.byteArrayToString(b,"utf8");c(null,e)})};this.loadAsDOM=function(a,c){y.loadAsString(a,function(a,b){if(a||null===b)c(a,null);else{var e=(new DOMParser).parseFromString(b,"text/xml");c(null,e)}})};this.loadAsDataURL=function(a,c,b){q(a,function(a,e){if(a||!e)return b(a,
null);var d=0,l;c||(c=80===e[1]&&78===e[2]&&71===e[3]?"image/png":255===e[0]&&216===e[1]&&255===e[2]?"image/jpeg":71===e[0]&&73===e[1]&&70===e[2]?"image/gif":"");for(l="data:"+c+";base64,";d<e.length;)l+=B.convertUTF8ArrayToBase64(e.subarray(d,Math.min(d+45E3,e.length))),d+=45E3;b(null,l)})};this.getEntries=function(){return e.slice()};l=-1;null===k?e=[]:runtime.getFileSize(g,function(a){l=a;0>l?k("File '"+g+"' cannot be read.",y):runtime.read(g,l-22,22,function(a,c){a||null===k||null===c?k(a,y):
n(c,k)})})};
// Input 21
xmldom.LSSerializerFilter=function(){};xmldom.LSSerializerFilter.prototype.acceptNode=function(g){};
// Input 22
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.OdfNodeFilter=function(){this.acceptNode=function(g){return"http://www.w3.org/1999/xhtml"===g.namespaceURI?NodeFilter.FILTER_SKIP:g.namespaceURI&&g.namespaceURI.match(/^urn:webodf:/)?NodeFilter.FILTER_REJECT:NodeFilter.FILTER_ACCEPT}};
// Input 23
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.Namespaces={namespaceMap:{db:"urn:oasis:names:tc:opendocument:xmlns:database:1.0",dc:"http://purl.org/dc/elements/1.1/",dr3d:"urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0",draw:"urn:oasis:names:tc:opendocument:xmlns:drawing:1.0",chart:"urn:oasis:names:tc:opendocument:xmlns:chart:1.0",fo:"urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0",form:"urn:oasis:names:tc:opendocument:xmlns:form:1.0",meta:"urn:oasis:names:tc:opendocument:xmlns:meta:1.0",number:"urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0",
office:"urn:oasis:names:tc:opendocument:xmlns:office:1.0",presentation:"urn:oasis:names:tc:opendocument:xmlns:presentation:1.0",style:"urn:oasis:names:tc:opendocument:xmlns:style:1.0",svg:"urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0",table:"urn:oasis:names:tc:opendocument:xmlns:table:1.0",text:"urn:oasis:names:tc:opendocument:xmlns:text:1.0",xlink:"http://www.w3.org/1999/xlink",xml:"http://www.w3.org/XML/1998/namespace"},prefixMap:{},dbns:"urn:oasis:names:tc:opendocument:xmlns:database:1.0",
dcns:"http://purl.org/dc/elements/1.1/",dr3dns:"urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0",drawns:"urn:oasis:names:tc:opendocument:xmlns:drawing:1.0",chartns:"urn:oasis:names:tc:opendocument:xmlns:chart:1.0",fons:"urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0",formns:"urn:oasis:names:tc:opendocument:xmlns:form:1.0",metans:"urn:oasis:names:tc:opendocument:xmlns:meta:1.0",numberns:"urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0",officens:"urn:oasis:names:tc:opendocument:xmlns:office:1.0",
presentationns:"urn:oasis:names:tc:opendocument:xmlns:presentation:1.0",stylens:"urn:oasis:names:tc:opendocument:xmlns:style:1.0",svgns:"urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0",tablens:"urn:oasis:names:tc:opendocument:xmlns:table:1.0",textns:"urn:oasis:names:tc:opendocument:xmlns:text:1.0",xlinkns:"http://www.w3.org/1999/xlink",xmlns:"http://www.w3.org/XML/1998/namespace"};
(function(){var g=odf.Namespaces.namespaceMap,k=odf.Namespaces.prefixMap,b;for(b in g)g.hasOwnProperty(b)&&(k[g[b]]=b)})();odf.Namespaces.forEachPrefix=function(g){var k=odf.Namespaces.namespaceMap,b;for(b in k)k.hasOwnProperty(b)&&g(b,k[b])};odf.Namespaces.lookupNamespaceURI=function(g){var k=null;odf.Namespaces.namespaceMap.hasOwnProperty(g)&&(k=odf.Namespaces.namespaceMap[g]);return k};odf.Namespaces.lookupPrefix=function(g){var k=odf.Namespaces.prefixMap;return k.hasOwnProperty(g)?k[g]:null};
odf.Namespaces.lookupNamespaceURI.lookupNamespaceURI=odf.Namespaces.lookupNamespaceURI;
// Input 24
xmldom.XPathIterator=function(){};xmldom.XPathIterator.prototype.next=function(){};xmldom.XPathIterator.prototype.reset=function(){};
function createXPathSingleton(){function g(b,c,a){return-1!==b&&(b<c||-1===c)&&(b<a||-1===a)}function k(b){for(var c=[],a=0,e=b.length,d;a<e;){var h=b,n=e,k=c,p="",q=[],r=h.indexOf("[",a),u=h.indexOf("/",a),w=h.indexOf("=",a);g(u,r,w)?(p=h.substring(a,u),a=u+1):g(r,u,w)?(p=h.substring(a,r),a=m(h,r,q)):g(w,u,r)?(p=h.substring(a,w),a=w):(p=h.substring(a,n),a=n);k.push({location:p,predicates:q});if(a<e&&"="===b[a]){d=b.substring(a+1,e);if(2<d.length&&("'"===d[0]||'"'===d[0]))d=d.slice(1,d.length-1);
else try{d=parseInt(d,10)}catch(x){}a=e}}return{steps:c,value:d}}function b(){var b=null,c=!1;this.setNode=function(a){b=a};this.reset=function(){c=!1};this.next=function(){var a=c?null:b;c=!0;return a}}function p(b,c,a){this.reset=function(){b.reset()};this.next=function(){for(var e=b.next();e;){e.nodeType===Node.ELEMENT_NODE&&(e=e.getAttributeNodeNS(c,a));if(e)break;e=b.next()}return e}}function d(b,c){var a=b.next(),e=null;this.reset=function(){b.reset();a=b.next();e=null};this.next=function(){for(;a;){if(e)if(c&&
e.firstChild)e=e.firstChild;else{for(;!e.nextSibling&&e!==a;)e=e.parentNode;e===a?a=b.next():e=e.nextSibling}else{do(e=a.firstChild)||(a=b.next());while(a&&!e)}if(e&&e.nodeType===Node.ELEMENT_NODE)return e}return null}}function h(b,c){this.reset=function(){b.reset()};this.next=function(){for(var a=b.next();a&&!c(a);)a=b.next();return a}}function n(b,c,a){c=c.split(":",2);var e=a(c[0]),d=c[1];return new h(b,function(a){return a.localName===d&&a.namespaceURI===e})}function q(d,c,a){var e=new b,l=r(e,
c,a),g=c.value;return void 0===g?new h(d,function(a){e.setNode(a);l.reset();return null!==l.next()}):new h(d,function(a){e.setNode(a);l.reset();return(a=l.next())?a.nodeValue===g:!1})}var r,m;m=function(b,c,a){for(var e=c,d=b.length,h=0;e<d;)"]"===b[e]?(h-=1,0>=h&&a.push(k(b.substring(c,e)))):"["===b[e]&&(0>=h&&(c=e+1),h+=1),e+=1;return e};r=function(b,c,a){var e,l,h,g;for(e=0;e<c.steps.length;e+=1){h=c.steps[e];l=h.location;if(""===l)b=new d(b,!1);else if("@"===l[0]){l=l.substr(1).split(":",2);g=
a(l[0]);if(!g)throw"No namespace associated with the prefix "+l[0];b=new p(b,g,l[1])}else"."!==l&&(b=new d(b,!1),-1!==l.indexOf(":")&&(b=n(b,l,a)));for(l=0;l<h.predicates.length;l+=1)g=h.predicates[l],b=q(b,g,a)}return b};return{getODFElementsWithXPath:function(d,c,a){var e=d.ownerDocument,l=[],h=null;if(e&&"function"===typeof e.evaluate)for(a=e.evaluate(c,d,a,XPathResult.UNORDERED_NODE_ITERATOR_TYPE,null),h=a.iterateNext();null!==h;)h.nodeType===Node.ELEMENT_NODE&&l.push(h),h=a.iterateNext();else{l=
new b;l.setNode(d);d=k(c);l=r(l,d,a);d=[];for(a=l.next();a;)d.push(a),a=l.next();l=d}return l}}}xmldom.XPath=createXPathSingleton();
// Input 25
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.StyleInfo=function(){function g(a,c){var b,d,e,l,f,h=0;if(b=H[a.localName])if(e=b[a.namespaceURI])h=e.length;for(b=0;b<h;b+=1)d=e[b],l=d.ns,f=d.localname,(d=a.getAttributeNS(l,f))&&a.setAttributeNS(l,U[l]+f,c+d);for(e=a.firstElementChild;e;)g(e,c),e=e.nextElementSibling}function k(a,c){var b,d,e,l,f,h=0;if(b=H[a.localName])if(e=b[a.namespaceURI])h=e.length;for(b=0;b<h;b+=1)if(d=e[b],l=d.ns,f=d.localname,d=a.getAttributeNS(l,f))d=d.replace(c,""),a.setAttributeNS(l,U[l]+f,d);for(e=a.firstElementChild;e;)k(e,
c),e=e.nextElementSibling}function b(a,c){var b,d,e,l,f,h=0;if(b=H[a.localName])if(e=b[a.namespaceURI])h=e.length;for(b=0;b<h;b+=1)if(l=e[b],d=l.ns,f=l.localname,d=a.getAttributeNS(d,f))c=c||{},l=l.keyname,c.hasOwnProperty(l)?c[l][d]=1:(f={},f[d]=1,c[l]=f);return c}function p(a,c){var d,e;b(a,c);for(d=a.firstChild;d;)d.nodeType===Node.ELEMENT_NODE&&(e=d,p(e,c)),d=d.nextSibling}function d(a,c,b){this.key=a;this.name=c;this.family=b;this.requires={}}function h(a,c,b){var e=a+'"'+c,l=b[e];l||(l=b[e]=
new d(e,a,c));return l}function n(a,c,b){var d,e,l,f,g,m=0;d=a.getAttributeNS(u,"name");f=a.getAttributeNS(u,"family");d&&f&&(c=h(d,f,b));if(c){if(d=H[a.localName])if(l=d[a.namespaceURI])m=l.length;for(d=0;d<m;d+=1)if(f=l[d],e=f.ns,g=f.localname,e=a.getAttributeNS(e,g))f=f.keyname,f=h(e,f,b),c.requires[f.key]=f}for(a=a.firstElementChild;a;)n(a,c,b),a=a.nextElementSibling;return b}function q(a,c){var b=c[a.family];b||(b=c[a.family]={});b[a.name]=1;Object.keys(a.requires).forEach(function(b){q(a.requires[b],
c)})}function r(a,c){var b=n(a,null,{});Object.keys(b).forEach(function(a){a=b[a];var d=c[a.family];d&&d.hasOwnProperty(a.name)&&q(a,c)})}function m(a,c){function b(c){(c=l.getAttributeNS(u,c))&&(a[c]=!0)}var d=["font-name","font-name-asian","font-name-complex"],e,l;for(e=c&&c.firstElementChild;e;)l=e,d.forEach(b),m(a,l),e=e.nextElementSibling}function f(a,c){function b(a){var d=l.getAttributeNS(u,a);d&&c.hasOwnProperty(d)&&l.setAttributeNS(u,"style:"+a,c[d])}var d=["font-name","font-name-asian",
"font-name-complex"],e,l;for(e=a&&a.firstElementChild;e;)l=e,d.forEach(b),f(l,c),e=e.nextElementSibling}function c(a,c,b){for(a=a.firstElementChild;a&&(a.namespaceURI!==u||"style"!==a.localName||a.getAttributeNS(u,"name")!==c||a.getAttributeNS(u,"family")!==b);)a=a.nextElementSibling;return a}function a(a,c){for(var b=a.firstElementChild,d,e,l,f;b;){for(l in c)if(c.hasOwnProperty(l))for(f in d=c[l],e=odf.Namespaces.namespaceMap[l],d)d.hasOwnProperty(f)&&null===d[f]&&b.hasAttributeNS(e,f)&&(d[f]=b.getAttributeNS(e,
f));b=b.nextElementSibling}}var e=odf.Namespaces.chartns,l=odf.Namespaces.dbns,s=odf.Namespaces.dr3dns,t=odf.Namespaces.drawns,y=odf.Namespaces.formns,B=odf.Namespaces.numberns,D=odf.Namespaces.officens,v=odf.Namespaces.presentationns,u=odf.Namespaces.stylens,w=odf.Namespaces.tablens,x=odf.Namespaces.textns,U={"urn:oasis:names:tc:opendocument:xmlns:chart:1.0":"chart:","urn:oasis:names:tc:opendocument:xmlns:database:1.0":"db:","urn:oasis:names:tc:opendocument:xmlns:dr3d:1.0":"dr3d:","urn:oasis:names:tc:opendocument:xmlns:drawing:1.0":"draw:",
"urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0":"fo:","urn:oasis:names:tc:opendocument:xmlns:form:1.0":"form:","urn:oasis:names:tc:opendocument:xmlns:datastyle:1.0":"number:","urn:oasis:names:tc:opendocument:xmlns:office:1.0":"office:","urn:oasis:names:tc:opendocument:xmlns:presentation:1.0":"presentation:","urn:oasis:names:tc:opendocument:xmlns:style:1.0":"style:","urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0":"svg:","urn:oasis:names:tc:opendocument:xmlns:table:1.0":"table:",
"urn:oasis:names:tc:opendocument:xmlns:text:1.0":"chart:","http://www.w3.org/XML/1998/namespace":"xml:"},E={text:[{ens:u,en:"tab-stop",ans:u,a:"leader-text-style"},{ens:u,en:"drop-cap",ans:u,a:"style-name"},{ens:x,en:"notes-configuration",ans:x,a:"citation-body-style-name"},{ens:x,en:"notes-configuration",ans:x,a:"citation-style-name"},{ens:x,en:"a",ans:x,a:"style-name"},{ens:x,en:"alphabetical-index",ans:x,a:"style-name"},{ens:x,en:"linenumbering-configuration",ans:x,a:"style-name"},{ens:x,en:"list-level-style-number",
ans:x,a:"style-name"},{ens:x,en:"ruby-text",ans:x,a:"style-name"},{ens:x,en:"span",ans:x,a:"style-name"},{ens:x,en:"a",ans:x,a:"visited-style-name"},{ens:u,en:"text-properties",ans:u,a:"text-line-through-text-style"},{ens:x,en:"alphabetical-index-source",ans:x,a:"main-entry-style-name"},{ens:x,en:"index-entry-bibliography",ans:x,a:"style-name"},{ens:x,en:"index-entry-chapter",ans:x,a:"style-name"},{ens:x,en:"index-entry-link-end",ans:x,a:"style-name"},{ens:x,en:"index-entry-link-start",ans:x,a:"style-name"},
{ens:x,en:"index-entry-page-number",ans:x,a:"style-name"},{ens:x,en:"index-entry-span",ans:x,a:"style-name"},{ens:x,en:"index-entry-tab-stop",ans:x,a:"style-name"},{ens:x,en:"index-entry-text",ans:x,a:"style-name"},{ens:x,en:"index-title-template",ans:x,a:"style-name"},{ens:x,en:"list-level-style-bullet",ans:x,a:"style-name"},{ens:x,en:"outline-level-style",ans:x,a:"style-name"}],paragraph:[{ens:t,en:"caption",ans:t,a:"text-style-name"},{ens:t,en:"circle",ans:t,a:"text-style-name"},{ens:t,en:"connector",
ans:t,a:"text-style-name"},{ens:t,en:"control",ans:t,a:"text-style-name"},{ens:t,en:"custom-shape",ans:t,a:"text-style-name"},{ens:t,en:"ellipse",ans:t,a:"text-style-name"},{ens:t,en:"frame",ans:t,a:"text-style-name"},{ens:t,en:"line",ans:t,a:"text-style-name"},{ens:t,en:"measure",ans:t,a:"text-style-name"},{ens:t,en:"path",ans:t,a:"text-style-name"},{ens:t,en:"polygon",ans:t,a:"text-style-name"},{ens:t,en:"polyline",ans:t,a:"text-style-name"},{ens:t,en:"rect",ans:t,a:"text-style-name"},{ens:t,en:"regular-polygon",
ans:t,a:"text-style-name"},{ens:D,en:"annotation",ans:t,a:"text-style-name"},{ens:y,en:"column",ans:y,a:"text-style-name"},{ens:u,en:"style",ans:u,a:"next-style-name"},{ens:w,en:"body",ans:w,a:"paragraph-style-name"},{ens:w,en:"even-columns",ans:w,a:"paragraph-style-name"},{ens:w,en:"even-rows",ans:w,a:"paragraph-style-name"},{ens:w,en:"first-column",ans:w,a:"paragraph-style-name"},{ens:w,en:"first-row",ans:w,a:"paragraph-style-name"},{ens:w,en:"last-column",ans:w,a:"paragraph-style-name"},{ens:w,
en:"last-row",ans:w,a:"paragraph-style-name"},{ens:w,en:"odd-columns",ans:w,a:"paragraph-style-name"},{ens:w,en:"odd-rows",ans:w,a:"paragraph-style-name"},{ens:x,en:"notes-configuration",ans:x,a:"default-style-name"},{ens:x,en:"alphabetical-index-entry-template",ans:x,a:"style-name"},{ens:x,en:"bibliography-entry-template",ans:x,a:"style-name"},{ens:x,en:"h",ans:x,a:"style-name"},{ens:x,en:"illustration-index-entry-template",ans:x,a:"style-name"},{ens:x,en:"index-source-style",ans:x,a:"style-name"},
{ens:x,en:"object-index-entry-template",ans:x,a:"style-name"},{ens:x,en:"p",ans:x,a:"style-name"},{ens:x,en:"table-index-entry-template",ans:x,a:"style-name"},{ens:x,en:"table-of-content-entry-template",ans:x,a:"style-name"},{ens:x,en:"table-index-entry-template",ans:x,a:"style-name"},{ens:x,en:"user-index-entry-template",ans:x,a:"style-name"},{ens:u,en:"page-layout-properties",ans:u,a:"register-truth-ref-style-name"}],chart:[{ens:e,en:"axis",ans:e,a:"style-name"},{ens:e,en:"chart",ans:e,a:"style-name"},
{ens:e,en:"data-label",ans:e,a:"style-name"},{ens:e,en:"data-point",ans:e,a:"style-name"},{ens:e,en:"equation",ans:e,a:"style-name"},{ens:e,en:"error-indicator",ans:e,a:"style-name"},{ens:e,en:"floor",ans:e,a:"style-name"},{ens:e,en:"footer",ans:e,a:"style-name"},{ens:e,en:"grid",ans:e,a:"style-name"},{ens:e,en:"legend",ans:e,a:"style-name"},{ens:e,en:"mean-value",ans:e,a:"style-name"},{ens:e,en:"plot-area",ans:e,a:"style-name"},{ens:e,en:"regression-curve",ans:e,a:"style-name"},{ens:e,en:"series",
ans:e,a:"style-name"},{ens:e,en:"stock-gain-marker",ans:e,a:"style-name"},{ens:e,en:"stock-loss-marker",ans:e,a:"style-name"},{ens:e,en:"stock-range-line",ans:e,a:"style-name"},{ens:e,en:"subtitle",ans:e,a:"style-name"},{ens:e,en:"title",ans:e,a:"style-name"},{ens:e,en:"wall",ans:e,a:"style-name"}],section:[{ens:x,en:"alphabetical-index",ans:x,a:"style-name"},{ens:x,en:"bibliography",ans:x,a:"style-name"},{ens:x,en:"illustration-index",ans:x,a:"style-name"},{ens:x,en:"index-title",ans:x,a:"style-name"},
{ens:x,en:"object-index",ans:x,a:"style-name"},{ens:x,en:"section",ans:x,a:"style-name"},{ens:x,en:"table-of-content",ans:x,a:"style-name"},{ens:x,en:"table-index",ans:x,a:"style-name"},{ens:x,en:"user-index",ans:x,a:"style-name"}],ruby:[{ens:x,en:"ruby",ans:x,a:"style-name"}],table:[{ens:l,en:"query",ans:l,a:"style-name"},{ens:l,en:"table-representation",ans:l,a:"style-name"},{ens:w,en:"background",ans:w,a:"style-name"},{ens:w,en:"table",ans:w,a:"style-name"}],"table-column":[{ens:l,en:"column",
ans:l,a:"style-name"},{ens:w,en:"table-column",ans:w,a:"style-name"}],"table-row":[{ens:l,en:"query",ans:l,a:"default-row-style-name"},{ens:l,en:"table-representation",ans:l,a:"default-row-style-name"},{ens:w,en:"table-row",ans:w,a:"style-name"}],"table-cell":[{ens:l,en:"column",ans:l,a:"default-cell-style-name"},{ens:w,en:"table-column",ans:w,a:"default-cell-style-name"},{ens:w,en:"table-row",ans:w,a:"default-cell-style-name"},{ens:w,en:"body",ans:w,a:"style-name"},{ens:w,en:"covered-table-cell",
ans:w,a:"style-name"},{ens:w,en:"even-columns",ans:w,a:"style-name"},{ens:w,en:"covered-table-cell",ans:w,a:"style-name"},{ens:w,en:"even-columns",ans:w,a:"style-name"},{ens:w,en:"even-rows",ans:w,a:"style-name"},{ens:w,en:"first-column",ans:w,a:"style-name"},{ens:w,en:"first-row",ans:w,a:"style-name"},{ens:w,en:"last-column",ans:w,a:"style-name"},{ens:w,en:"last-row",ans:w,a:"style-name"},{ens:w,en:"odd-columns",ans:w,a:"style-name"},{ens:w,en:"odd-rows",ans:w,a:"style-name"},{ens:w,en:"table-cell",
ans:w,a:"style-name"}],graphic:[{ens:s,en:"cube",ans:t,a:"style-name"},{ens:s,en:"extrude",ans:t,a:"style-name"},{ens:s,en:"rotate",ans:t,a:"style-name"},{ens:s,en:"scene",ans:t,a:"style-name"},{ens:s,en:"sphere",ans:t,a:"style-name"},{ens:t,en:"caption",ans:t,a:"style-name"},{ens:t,en:"circle",ans:t,a:"style-name"},{ens:t,en:"connector",ans:t,a:"style-name"},{ens:t,en:"control",ans:t,a:"style-name"},{ens:t,en:"custom-shape",ans:t,a:"style-name"},{ens:t,en:"ellipse",ans:t,a:"style-name"},{ens:t,en:"frame",
ans:t,a:"style-name"},{ens:t,en:"g",ans:t,a:"style-name"},{ens:t,en:"line",ans:t,a:"style-name"},{ens:t,en:"measure",ans:t,a:"style-name"},{ens:t,en:"page-thumbnail",ans:t,a:"style-name"},{ens:t,en:"path",ans:t,a:"style-name"},{ens:t,en:"polygon",ans:t,a:"style-name"},{ens:t,en:"polyline",ans:t,a:"style-name"},{ens:t,en:"rect",ans:t,a:"style-name"},{ens:t,en:"regular-polygon",ans:t,a:"style-name"},{ens:D,en:"annotation",ans:t,a:"style-name"}],presentation:[{ens:s,en:"cube",ans:v,a:"style-name"},{ens:s,
en:"extrude",ans:v,a:"style-name"},{ens:s,en:"rotate",ans:v,a:"style-name"},{ens:s,en:"scene",ans:v,a:"style-name"},{ens:s,en:"sphere",ans:v,a:"style-name"},{ens:t,en:"caption",ans:v,a:"style-name"},{ens:t,en:"circle",ans:v,a:"style-name"},{ens:t,en:"connector",ans:v,a:"style-name"},{ens:t,en:"control",ans:v,a:"style-name"},{ens:t,en:"custom-shape",ans:v,a:"style-name"},{ens:t,en:"ellipse",ans:v,a:"style-name"},{ens:t,en:"frame",ans:v,a:"style-name"},{ens:t,en:"g",ans:v,a:"style-name"},{ens:t,en:"line",
ans:v,a:"style-name"},{ens:t,en:"measure",ans:v,a:"style-name"},{ens:t,en:"page-thumbnail",ans:v,a:"style-name"},{ens:t,en:"path",ans:v,a:"style-name"},{ens:t,en:"polygon",ans:v,a:"style-name"},{ens:t,en:"polyline",ans:v,a:"style-name"},{ens:t,en:"rect",ans:v,a:"style-name"},{ens:t,en:"regular-polygon",ans:v,a:"style-name"},{ens:D,en:"annotation",ans:v,a:"style-name"}],"drawing-page":[{ens:t,en:"page",ans:t,a:"style-name"},{ens:v,en:"notes",ans:t,a:"style-name"},{ens:u,en:"handout-master",ans:t,a:"style-name"},
{ens:u,en:"master-page",ans:t,a:"style-name"}],"list-style":[{ens:x,en:"list",ans:x,a:"style-name"},{ens:x,en:"numbered-paragraph",ans:x,a:"style-name"},{ens:x,en:"list-item",ans:x,a:"style-override"},{ens:u,en:"style",ans:u,a:"list-style-name"}],data:[{ens:u,en:"style",ans:u,a:"data-style-name"},{ens:u,en:"style",ans:u,a:"percentage-data-style-name"},{ens:v,en:"date-time-decl",ans:u,a:"data-style-name"},{ens:x,en:"creation-date",ans:u,a:"data-style-name"},{ens:x,en:"creation-time",ans:u,a:"data-style-name"},
{ens:x,en:"database-display",ans:u,a:"data-style-name"},{ens:x,en:"date",ans:u,a:"data-style-name"},{ens:x,en:"editing-duration",ans:u,a:"data-style-name"},{ens:x,en:"expression",ans:u,a:"data-style-name"},{ens:x,en:"meta-field",ans:u,a:"data-style-name"},{ens:x,en:"modification-date",ans:u,a:"data-style-name"},{ens:x,en:"modification-time",ans:u,a:"data-style-name"},{ens:x,en:"print-date",ans:u,a:"data-style-name"},{ens:x,en:"print-time",ans:u,a:"data-style-name"},{ens:x,en:"table-formula",ans:u,
a:"data-style-name"},{ens:x,en:"time",ans:u,a:"data-style-name"},{ens:x,en:"user-defined",ans:u,a:"data-style-name"},{ens:x,en:"user-field-get",ans:u,a:"data-style-name"},{ens:x,en:"user-field-input",ans:u,a:"data-style-name"},{ens:x,en:"variable-get",ans:u,a:"data-style-name"},{ens:x,en:"variable-input",ans:u,a:"data-style-name"},{ens:x,en:"variable-set",ans:u,a:"data-style-name"}],"page-layout":[{ens:v,en:"notes",ans:u,a:"page-layout-name"},{ens:u,en:"handout-master",ans:u,a:"page-layout-name"},
{ens:u,en:"master-page",ans:u,a:"page-layout-name"}]},H,T=xmldom.XPath;this.collectUsedFontFaces=m;this.changeFontFaceNames=f;this.UsedStyleList=function(a,c){var b={};this.uses=function(a){var c=a.localName,d=a.getAttributeNS(t,"name")||a.getAttributeNS(u,"name");a="style"===c?a.getAttributeNS(u,"family"):a.namespaceURI===B?"data":c;return(a=b[a])?0<a[d]:!1};p(a,b);c&&r(c,b)};this.getStyleProperties=function(b,d,e,l,f){var h=null,g={};if(d=c(d,e,l))a(d,f),d.hasAttributeNS(u,"parent-style-name")&&
(h=d.getAttributeNS(u,"parent-style-name"));for(;null!==h&&!g[h];)d=c(b,h,l),g[h]=!0,h=null,d&&(a(d,f),d.hasAttributeNS(u,"parent-style-name")&&(h=d.getAttributeNS(u,"parent-style-name")));return f};this.hasDerivedStyles=function(a,c,b){var d=b.getAttributeNS(u,"name");b=b.getAttributeNS(u,"family");return T.getODFElementsWithXPath(a,"//style:*[@style:parent-style-name='"+d+"'][@style:family='"+b+"']",c).length?!0:!1};this.prefixStyleNames=function(a,c,b){var d;if(a){for(d=a.firstChild;d;){if(d.nodeType===
Node.ELEMENT_NODE){var e=d,l=c,f=e.getAttributeNS(t,"name"),h=void 0;f?h=t:(f=e.getAttributeNS(u,"name"))&&(h=u);h&&e.setAttributeNS(h,U[h]+"name",l+f)}d=d.nextSibling}g(a,c);b&&g(b,c)}};this.removePrefixFromStyleNames=function(a,c,b){var d=RegExp("^"+c);if(a){for(c=a.firstChild;c;){if(c.nodeType===Node.ELEMENT_NODE){var e=c,l=d,f=e.getAttributeNS(t,"name"),h=void 0;f?h=t:(f=e.getAttributeNS(u,"name"))&&(h=u);h&&(f=f.replace(l,""),e.setAttributeNS(h,U[h]+"name",f))}c=c.nextSibling}k(a,d);b&&k(b,d)}};
this.determineStylesForNode=b;H=function(){var a,c,b,d,e,l={},f,h,g,m;for(b in E)if(E.hasOwnProperty(b))for(d=E[b],c=d.length,a=0;a<c;a+=1)e=d[a],g=e.en,m=e.ens,l.hasOwnProperty(g)?f=l[g]:l[g]=f={},f.hasOwnProperty(m)?h=f[m]:f[m]=h=[],h.push({ns:e.ans,localname:e.a,keyname:b});return l}()};
// Input 26
"function"!==typeof Object.create&&(Object.create=function(g){var k=function(){};k.prototype=g;return new k});
xmldom.LSSerializer=function(){function g(b){var h=b||{},g=function(b){var c={},a;for(a in b)b.hasOwnProperty(a)&&(c[b[a]]=a);return c}(b),k=[h],p=[g],m=0;this.push=function(){m+=1;h=k[m]=Object.create(h);g=p[m]=Object.create(g)};this.pop=function(){k.pop();p.pop();m-=1;h=k[m];g=p[m]};this.getLocalNamespaceDefinitions=function(){return g};this.getQName=function(b){var c=b.namespaceURI,a=0,d;if(!c)return b.localName;if(d=g[c])return d+":"+b.localName;do{d||!b.prefix?(d="ns"+a,a+=1):d=b.prefix;if(h[d]===
c)break;if(!h[d]){h[d]=c;g[c]=d;break}d=null}while(null===d);return d+":"+b.localName}}function k(b){return b.replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/'/g,"&apos;").replace(/"/g,"&quot;")}function b(d,h){var g="",q=p.filter?p.filter.acceptNode(h):NodeFilter.FILTER_ACCEPT,r;if(q===NodeFilter.FILTER_ACCEPT&&h.nodeType===Node.ELEMENT_NODE){d.push();r=d.getQName(h);var m,f=h.attributes,c,a,e,l="",s;m="<"+r;c=f.length;for(a=0;a<c;a+=1)e=f.item(a),"http://www.w3.org/2000/xmlns/"!==
e.namespaceURI&&(s=p.filter?p.filter.acceptNode(e):NodeFilter.FILTER_ACCEPT,s===NodeFilter.FILTER_ACCEPT&&(s=d.getQName(e),e="string"===typeof e.value?k(e.value):e.value,l+=" "+(s+'="'+e+'"')));c=d.getLocalNamespaceDefinitions();for(a in c)c.hasOwnProperty(a)&&((f=c[a])?"xmlns"!==f&&(m+=" xmlns:"+c[a]+'="'+a+'"'):m+=' xmlns="'+a+'"');g+=m+(l+">")}if(q===NodeFilter.FILTER_ACCEPT||q===NodeFilter.FILTER_SKIP){for(q=h.firstChild;q;)g+=b(d,q),q=q.nextSibling;h.nodeValue&&(g+=k(h.nodeValue))}r&&(g+="</"+
r+">",d.pop());return g}var p=this;this.filter=null;this.writeToString=function(d,h){if(!d)return"";var n=new g(h);return b(n,d)}};
// Input 27
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
(function(){function g(c,a,b){for(c=c?c.firstChild:null;c;){if(c.localName===b&&c.namespaceURI===a)return c;c=c.nextSibling}return null}function k(c){var a,b=r.length;for(a=0;a<b;a+=1)if("urn:oasis:names:tc:opendocument:xmlns:office:1.0"===c.namespaceURI&&c.localName===r[a])return a;return-1}function b(c,a){var b=new h.UsedStyleList(c,a),d=new odf.OdfNodeFilter;this.acceptNode=function(c){var f=d.acceptNode(c);f===NodeFilter.FILTER_ACCEPT&&c.parentNode===a&&c.nodeType===Node.ELEMENT_NODE&&(f=b.uses(c)?
NodeFilter.FILTER_ACCEPT:NodeFilter.FILTER_REJECT);return f}}function p(c,a){var d=new b(c,a);this.acceptNode=function(a){var c=d.acceptNode(a);c!==NodeFilter.FILTER_ACCEPT||!a.parentNode||a.parentNode.namespaceURI!==odf.Namespaces.textns||"s"!==a.parentNode.localName&&"tab"!==a.parentNode.localName||(c=NodeFilter.FILTER_REJECT);return c}}function d(c,a){if(a){var b=k(a),d,f=c.firstChild;if(-1!==b){for(;f;){d=k(f);if(-1!==d&&d>b)break;f=f.nextSibling}c.insertBefore(a,f)}}}var h=new odf.StyleInfo,
n=new core.DomUtils,q=odf.Namespaces.stylens,r="meta settings scripts font-face-decls styles automatic-styles master-styles body".split(" "),m=(new Date).getTime()+"_webodf_",f=new core.Base64;odf.ODFElement=function(){};odf.ODFDocumentElement=function(){};odf.ODFDocumentElement.prototype=new odf.ODFElement;odf.ODFDocumentElement.prototype.constructor=odf.ODFDocumentElement;odf.ODFDocumentElement.prototype.fontFaceDecls=null;odf.ODFDocumentElement.prototype.manifest=null;odf.ODFDocumentElement.prototype.settings=
null;odf.ODFDocumentElement.namespaceURI="urn:oasis:names:tc:opendocument:xmlns:office:1.0";odf.ODFDocumentElement.localName="document";odf.AnnotationElement=function(){};odf.OdfPart=function(c,a,b,d){var f=this;this.size=0;this.type=null;this.name=c;this.container=b;this.url=null;this.mimetype=a;this.onstatereadychange=this.document=null;this.EMPTY=0;this.LOADING=1;this.DONE=2;this.state=this.EMPTY;this.data="";this.load=function(){null!==d&&(this.mimetype=a,d.loadAsDataURL(c,a,function(a,c){a&&
runtime.log(a);f.url=c;if(f.onchange)f.onchange(f);if(f.onstatereadychange)f.onstatereadychange(f)}))}};odf.OdfPart.prototype.load=function(){};odf.OdfPart.prototype.getUrl=function(){return this.data?"data:;base64,"+f.toBase64(this.data):null};odf.OdfContainer=function a(e,l){function k(a){for(var b=a.firstChild,d;b;)d=b.nextSibling,b.nodeType===Node.ELEMENT_NODE?k(b):b.nodeType===Node.PROCESSING_INSTRUCTION_NODE&&a.removeChild(b),b=d}function r(a){var b={},d,e,l=a.ownerDocument.createNodeIterator(a,
NodeFilter.SHOW_ELEMENT,null,!1);for(a=l.nextNode();a;)"urn:oasis:names:tc:opendocument:xmlns:office:1.0"===a.namespaceURI&&("annotation"===a.localName?(d=a.getAttributeNS("urn:oasis:names:tc:opendocument:xmlns:office:1.0","name"))&&(b.hasOwnProperty(d)?runtime.log("Warning: annotation name used more than once with <office:annotation/>: '"+d+"'"):b[d]=a):"annotation-end"===a.localName&&((d=a.getAttributeNS("urn:oasis:names:tc:opendocument:xmlns:office:1.0","name"))?b.hasOwnProperty(d)?(e=b[d],e.annotationEndElement?
runtime.log("Warning: annotation name used more than once with <office:annotation-end/>: '"+d+"'"):e.annotationEndElement=a):runtime.log("Warning: annotation end without an annotation start, name: '"+d+"'"):runtime.log("Warning: annotation end without a name found"))),a=l.nextNode()}function y(a,b){for(var d=a&&a.firstChild;d;)d.nodeType===Node.ELEMENT_NODE&&d.setAttributeNS("urn:webodf:names:scope","scope",b),d=d.nextSibling}function B(a){var b={},d;for(a=a.firstChild;a;)a.nodeType===Node.ELEMENT_NODE&&
a.namespaceURI===q&&"font-face"===a.localName&&(d=a.getAttributeNS(q,"name"),b[d]=a),a=a.nextSibling;return b}function D(a,b){var d=null,e,l,f;if(a)for(d=a.cloneNode(!0),e=d.firstElementChild;e;)l=e.nextElementSibling,(f=e.getAttributeNS("urn:webodf:names:scope","scope"))&&f!==b&&d.removeChild(e),e=l;return d}function v(a,b){var d,e,l,f=null,g={};if(a)for(b.forEach(function(a){h.collectUsedFontFaces(g,a)}),f=a.cloneNode(!0),d=f.firstElementChild;d;)e=d.nextElementSibling,l=d.getAttributeNS(q,"name"),
g[l]||f.removeChild(d),d=e;return f}function u(a){var b=I.rootElement.ownerDocument,d;if(a){k(a.documentElement);try{d=b.importNode(a.documentElement,!0)}catch(e){}}return d}function w(a){I.state=a;if(I.onchange)I.onchange(I);if(I.onstatereadychange)I.onstatereadychange(I)}function x(a){O=null;I.rootElement=a;a.fontFaceDecls=g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","font-face-decls");a.styles=g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","styles");a.automaticStyles=g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0",
"automatic-styles");a.masterStyles=g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","master-styles");a.body=g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","body");a.meta=g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","meta");r(a)}function U(b){var e=u(b),l=I.rootElement,f;e&&"document-styles"===e.localName&&"urn:oasis:names:tc:opendocument:xmlns:office:1.0"===e.namespaceURI?(l.fontFaceDecls=g(e,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","font-face-decls"),d(l,l.fontFaceDecls),
f=g(e,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","styles"),l.styles=f||b.createElementNS("urn:oasis:names:tc:opendocument:xmlns:office:1.0","styles"),d(l,l.styles),f=g(e,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","automatic-styles"),l.automaticStyles=f||b.createElementNS("urn:oasis:names:tc:opendocument:xmlns:office:1.0","automatic-styles"),y(l.automaticStyles,"document-styles"),d(l,l.automaticStyles),e=g(e,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","master-styles"),l.masterStyles=
e||b.createElementNS("urn:oasis:names:tc:opendocument:xmlns:office:1.0","master-styles"),d(l,l.masterStyles),h.prefixStyleNames(l.automaticStyles,m,l.masterStyles)):w(a.INVALID)}function E(b){b=u(b);var e,l,f,m;if(b&&"document-content"===b.localName&&"urn:oasis:names:tc:opendocument:xmlns:office:1.0"===b.namespaceURI){e=I.rootElement;f=g(b,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","font-face-decls");if(e.fontFaceDecls&&f){m=e.fontFaceDecls;var n,k,p,r,s={};l=B(m);r=B(f);for(f=f.firstElementChild;f;){n=
f.nextElementSibling;if(f.namespaceURI===q&&"font-face"===f.localName)if(k=f.getAttributeNS(q,"name"),l.hasOwnProperty(k)){if(!f.isEqualNode(l[k])){p=k;for(var x=l,H=r,t=0,R=void 0,R=p=p.replace(/\d+$/,"");x.hasOwnProperty(R)||H.hasOwnProperty(R);)t+=1,R=p+t;p=R;f.setAttributeNS(q,"style:name",p);m.appendChild(f);l[p]=f;delete r[k];s[k]=p}}else m.appendChild(f),l[k]=f,delete r[k];f=n}m=s}else f&&(e.fontFaceDecls=f,d(e,f));l=g(b,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","automatic-styles");
y(l,"document-content");m&&h.changeFontFaceNames(l,m);if(e.automaticStyles&&l)for(m=l.firstChild;m;)e.automaticStyles.appendChild(m),m=l.firstChild;else l&&(e.automaticStyles=l,d(e,l));b=g(b,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","body");if(null===b)throw"<office:body/> tag is mising.";e.body=b;d(e,e.body)}else w(a.INVALID)}function H(a){a=u(a);var b;a&&"document-meta"===a.localName&&"urn:oasis:names:tc:opendocument:xmlns:office:1.0"===a.namespaceURI&&(b=I.rootElement,b.meta=g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0",
"meta"),d(b,b.meta))}function T(a){a=u(a);var b;a&&"document-settings"===a.localName&&"urn:oasis:names:tc:opendocument:xmlns:office:1.0"===a.namespaceURI&&(b=I.rootElement,b.settings=g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","settings"),d(b,b.settings))}function F(a){a=u(a);var b;if(a&&"manifest"===a.localName&&"urn:oasis:names:tc:opendocument:xmlns:manifest:1.0"===a.namespaceURI)for(b=I.rootElement,b.manifest=a,a=b.manifest.firstElementChild;a;)"file-entry"===a.localName&&"urn:oasis:names:tc:opendocument:xmlns:manifest:1.0"===
a.namespaceURI&&(V[a.getAttributeNS("urn:oasis:names:tc:opendocument:xmlns:manifest:1.0","full-path")]=a.getAttributeNS("urn:oasis:names:tc:opendocument:xmlns:manifest:1.0","media-type")),a=a.nextElementSibling}function Z(b){var d=b.shift();d?J.loadAsDOM(d.path,function(e,l){d.handler(l);e||I.state===a.INVALID||Z(b)}):(r(I.rootElement),w(a.DONE))}function ba(a){var b="";odf.Namespaces.forEachPrefix(function(a,d){b+=" xmlns:"+a+'="'+d+'"'});return'<?xml version="1.0" encoding="UTF-8"?><office:'+a+
" "+b+' office:version="1.2">'}function N(){var a=new xmldom.LSSerializer,b=ba("document-meta");a.filter=new odf.OdfNodeFilter;b+=a.writeToString(I.rootElement.meta,odf.Namespaces.namespaceMap);return b+"</office:document-meta>"}function G(a,b){var d=document.createElementNS("urn:oasis:names:tc:opendocument:xmlns:manifest:1.0","manifest:file-entry");d.setAttributeNS("urn:oasis:names:tc:opendocument:xmlns:manifest:1.0","manifest:full-path",a);d.setAttributeNS("urn:oasis:names:tc:opendocument:xmlns:manifest:1.0",
"manifest:media-type",b);return d}function R(){var a=runtime.parseXML('<manifest:manifest xmlns:manifest="urn:oasis:names:tc:opendocument:xmlns:manifest:1.0" manifest:version="1.2"></manifest:manifest>'),b=g(a,"urn:oasis:names:tc:opendocument:xmlns:manifest:1.0","manifest"),d=new xmldom.LSSerializer,e;for(e in V)V.hasOwnProperty(e)&&b.appendChild(G(e,V[e]));d.filter=new odf.OdfNodeFilter;return'<?xml version="1.0" encoding="UTF-8" standalone="yes"?>\n'+d.writeToString(a,odf.Namespaces.namespaceMap)}
function z(){var a=new xmldom.LSSerializer,b=ba("document-settings");a.filter=new odf.OdfNodeFilter;I.rootElement.settings.firstElementChild&&(b+=a.writeToString(I.rootElement.settings,odf.Namespaces.namespaceMap));return b+"</office:document-settings>"}function fa(){var a,d,e,l=odf.Namespaces.namespaceMap,f=new xmldom.LSSerializer,g=ba("document-styles");d=D(I.rootElement.automaticStyles,"document-styles");e=I.rootElement.masterStyles.cloneNode(!0);a=v(I.rootElement.fontFaceDecls,[e,I.rootElement.styles,
d]);h.removePrefixFromStyleNames(d,m,e);f.filter=new b(e,d);g+=f.writeToString(a,l);g+=f.writeToString(I.rootElement.styles,l);g+=f.writeToString(d,l);g+=f.writeToString(e,l);return g+"</office:document-styles>"}function ea(){var a,b,d=odf.Namespaces.namespaceMap,e=new xmldom.LSSerializer,l=ba("document-content");b=D(I.rootElement.automaticStyles,"document-content");a=v(I.rootElement.fontFaceDecls,[b]);e.filter=new p(I.rootElement.body,b);l+=e.writeToString(a,d);l+=e.writeToString(b,d);l+=e.writeToString(I.rootElement.body,
d);return l+"</office:document-content>"}function L(b,d){runtime.loadXML(b,function(b,e){if(b)d(b);else{var l=u(e);l&&"document"===l.localName&&"urn:oasis:names:tc:opendocument:xmlns:office:1.0"===l.namespaceURI?(x(l),w(a.DONE)):w(a.INVALID)}})}function K(a,b){var e;e=I.rootElement;var l=e.meta;l||(e.meta=l=document.createElementNS("urn:oasis:names:tc:opendocument:xmlns:office:1.0","meta"),d(e,l));e=l;a&&n.mapKeyValObjOntoNode(e,a,odf.Namespaces.lookupNamespaceURI);b&&n.removeKeyElementsFromNode(e,
b,odf.Namespaces.lookupNamespaceURI)}function Q(){function b(a,d){var e;d||(d=a);e=document.createElementNS("urn:oasis:names:tc:opendocument:xmlns:office:1.0",d);l[a]=e;l.appendChild(e)}var d=new core.Zip("",null),e=runtime.byteArrayFromString("application/vnd.oasis.opendocument.text","utf8"),l=I.rootElement,f=document.createElementNS("urn:oasis:names:tc:opendocument:xmlns:office:1.0","text");d.save("mimetype",e,!1,new Date);b("meta");b("settings");b("scripts");b("fontFaceDecls","font-face-decls");
b("styles");b("automaticStyles","automatic-styles");b("masterStyles","master-styles");b("body");l.body.appendChild(f);V["/"]="application/vnd.oasis.opendocument.text";V["settings.xml"]="text/xml";V["meta.xml"]="text/xml";V["styles.xml"]="text/xml";V["content.xml"]="text/xml";w(a.DONE);return d}function ga(){var a,b=new Date,d=runtime.getWindow();a="WebODF/"+("undefined"!==String(typeof webodf_version)?webodf_version:"FromSource");d&&(a=a+" "+d.navigator.userAgent);K({"meta:generator":a},null);a=runtime.byteArrayFromString(z(),
"utf8");J.save("settings.xml",a,!0,b);a=runtime.byteArrayFromString(N(),"utf8");J.save("meta.xml",a,!0,b);a=runtime.byteArrayFromString(fa(),"utf8");J.save("styles.xml",a,!0,b);a=runtime.byteArrayFromString(ea(),"utf8");J.save("content.xml",a,!0,b);a=runtime.byteArrayFromString(R(),"utf8");J.save("META-INF/manifest.xml",a,!0,b)}function W(a,b){ga();J.writeAs(a,function(a){b(a)})}var I=this,J,V={},O;this.onstatereadychange=l;this.state=this.onchange=null;this.setRootElement=x;this.getContentElement=
function(){var a;O||(a=I.rootElement.body,O=g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","text")||g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","presentation")||g(a,"urn:oasis:names:tc:opendocument:xmlns:office:1.0","spreadsheet"));if(!O)throw"Could not find content element in <office:body/>.";return O};this.getDocumentType=function(){var a=I.getContentElement();return a&&a.localName};this.getPart=function(a){return new odf.OdfPart(a,V[a],I,J)};this.getPartData=function(a,b){J.load(a,
b)};this.setMetadata=K;this.incrementEditingCycles=function(){var a;for(a=(a=I.rootElement.meta)&&a.firstChild;a&&(a.namespaceURI!==odf.Namespaces.metans||"editing-cycles"!==a.localName);)a=a.nextSibling;for(a=a&&a.firstChild;a&&a.nodeType!==Node.TEXT_NODE;)a=a.nextSibling;a=a?a.data:null;a=a?parseInt(a,10):0;isNaN(a)&&(a=0);K({"meta:editing-cycles":a+1},null)};this.createByteArray=function(a,b){ga();J.createByteArray(a,b)};this.saveAs=W;this.save=function(a){W(e,a)};this.getUrl=function(){return e};
this.setBlob=function(a,b,d){d=f.convertBase64ToByteArray(d);J.save(a,d,!1,new Date);V.hasOwnProperty(a)&&runtime.log(a+" has been overwritten.");V[a]=b};this.removeBlob=function(a){var b=J.remove(a);runtime.assert(b,"file is not found: "+a);delete V[a]};this.state=a.LOADING;this.rootElement=function(a){var b=document.createElementNS(a.namespaceURI,a.localName),d;a=new a.Type;for(d in a)a.hasOwnProperty(d)&&(b[d]=a[d]);return b}({Type:odf.ODFDocumentElement,namespaceURI:odf.ODFDocumentElement.namespaceURI,
localName:odf.ODFDocumentElement.localName});J=e?new core.Zip(e,function(b,d){J=d;b?L(e,function(d){b&&(J.error=b+"\n"+d,w(a.INVALID))}):Z([{path:"styles.xml",handler:U},{path:"content.xml",handler:E},{path:"meta.xml",handler:H},{path:"settings.xml",handler:T},{path:"META-INF/manifest.xml",handler:F}])}):Q()};odf.OdfContainer.EMPTY=0;odf.OdfContainer.LOADING=1;odf.OdfContainer.DONE=2;odf.OdfContainer.INVALID=3;odf.OdfContainer.SAVING=4;odf.OdfContainer.MODIFIED=5;odf.OdfContainer.getContainer=function(a){return new odf.OdfContainer(a,
null)};return odf.OdfContainer})();
// Input 28
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.OdfUtils=function(){function g(a){return"image"===(a&&a.localName)&&a.namespaceURI===Z}function k(a){return null!==a&&a.nodeType===Node.ELEMENT_NODE&&"frame"===a.localName&&a.namespaceURI===Z&&"as-char"===a.getAttributeNS(F,"anchor-type")}function b(a){var b;(b="annotation"===(a&&a.localName)&&a.namespaceURI===odf.Namespaces.officens)||(b="div"===(a&&a.localName)&&"annotationWrapper"===a.className);return b}function p(a){return"a"===(a&&a.localName)&&a.namespaceURI===F}function d(a){var b=a&&
a.localName;return("p"===b||"h"===b)&&a.namespaceURI===F}function h(a){for(;a&&!d(a);)a=a.parentNode;return a}function n(a){return/^[ \t\r\n]+$/.test(a)}function q(a){if(null===a||a.nodeType!==Node.ELEMENT_NODE)return!1;var b=a.localName;return/^(span|p|h|a|meta)$/.test(b)&&a.namespaceURI===F||"span"===b&&"annotationHighlight"===a.className}function r(a){var b=a&&a.localName,c=!1;b&&(a=a.namespaceURI,a===F&&(c="s"===b||"tab"===b||"line-break"===b));return c}function m(a){return r(a)||k(a)||b(a)}function f(a){var b=
a&&a.localName,c=!1;b&&(a=a.namespaceURI,a===F&&(c="s"===b));return c}function c(a){for(;null!==a.firstChild&&q(a);)a=a.firstChild;return a}function a(a){for(;null!==a.lastChild&&q(a);)a=a.lastChild;return a}function e(b){for(;!d(b)&&null===b.previousSibling;)b=b.parentNode;return d(b)?null:a(b.previousSibling)}function l(a){for(;!d(a)&&null===a.nextSibling;)a=a.parentNode;return d(a)?null:c(a.nextSibling)}function s(a){for(var b=!1;a;)if(a.nodeType===Node.TEXT_NODE)if(0===a.length)a=e(a);else return!n(a.data.substr(a.length-
1,1));else m(a)?(b=!1===f(a),a=null):a=e(a);return b}function t(a){var b=!1,d;for(a=a&&c(a);a;){d=a.nodeType===Node.TEXT_NODE?a.length:0;if(0<d&&!n(a.data)){b=!0;break}if(m(a)){b=!0;break}a=l(a)}return b}function y(a,b){return n(a.data.substr(b))?!t(l(a)):!1}function B(a,b){var c=a.data,d;if(!n(c[b])||m(a.parentNode))return!1;0<b?n(c[b-1])||(d=!0):s(e(a))&&(d=!0);return!0===d?y(a,b)?!1:!0:!1}function D(a){return(a=/(-?[0-9]*[0-9][0-9]*(\.[0-9]*)?|0+\.[0-9]*[1-9][0-9]*|\.[0-9]*[1-9][0-9]*)((cm)|(mm)|(in)|(pt)|(pc)|(px)|(%))/.exec(a))?
{value:parseFloat(a[1]),unit:a[3]}:null}function v(a){return(a=D(a))&&(0>a.value||"%"===a.unit)?null:a}function u(a){return(a=D(a))&&"%"!==a.unit?null:a}function w(a){switch(a.namespaceURI){case odf.Namespaces.drawns:case odf.Namespaces.svgns:case odf.Namespaces.dr3dns:return!1;case odf.Namespaces.textns:switch(a.localName){case "note-body":case "ruby-text":return!1}break;case odf.Namespaces.officens:switch(a.localName){case "annotation":case "binary-data":case "event-listeners":return!1}break;default:switch(a.localName){case "cursor":case "editinfo":return!1}}return!0}
function x(a,b){for(;0<b.length&&!G.rangeContainsNode(a,b[0]);)b.shift();for(;0<b.length&&!G.rangeContainsNode(a,b[b.length-1]);)b.pop()}function U(a,c,d){var e;e=G.getNodesInRange(a,function(a){var c=NodeFilter.FILTER_REJECT;if(r(a.parentNode)||b(a))c=NodeFilter.FILTER_REJECT;else if(a.nodeType===Node.TEXT_NODE){if(d||Boolean(h(a)&&(!n(a.textContent)||B(a,0))))c=NodeFilter.FILTER_ACCEPT}else if(m(a))c=NodeFilter.FILTER_ACCEPT;else if(w(a)||q(a))c=NodeFilter.FILTER_SKIP;return c},NodeFilter.SHOW_ELEMENT|
NodeFilter.SHOW_TEXT);c||x(a,e);return e}function E(a,c,d){for(;a;){if(d(a)){c[0]!==a&&c.unshift(a);break}if(b(a))break;a=a.parentNode}}function H(a,b){var c=a;if(b<c.childNodes.length-1)c=c.childNodes[b+1];else{for(;!c.nextSibling;)c=c.parentNode;c=c.nextSibling}for(;c.firstChild;)c=c.firstChild;return c}function T(a){var b=-1;if("number"===typeof a)b=a;else if((a=D(a))&&"px"===a.unit)b=a.value;else if(a&&"cm"===a.unit)b=96*(a.value/2.54);else if(a&&"mm"===a.unit)b=96*(a.value/25.4);else if(a&&"in"===
a.unit)b=96*a.value;else if(a&&"pt"===a.unit)b=a.value/0.75;else if(a&&"pc"===a.unit)b=16*a.value;else throw"Unit "+a.unit+" not supported by this function.";return b}var F=odf.Namespaces.textns,Z=odf.Namespaces.drawns,ba=odf.Namespaces.xlinkns,N=/^\s*$/,G=new core.DomUtils;this.isImage=g;this.isCharacterFrame=k;this.isInlineRoot=b;this.isTextSpan=function(a){return"span"===(a&&a.localName)&&a.namespaceURI===F};this.isHyperlink=p;this.getHyperlinkTarget=function(a){return a.getAttributeNS(ba,"href")};
this.isParagraph=d;this.getParagraphElement=h;this.isWithinTrackedChanges=function(a,b){for(;a&&a!==b;){if(a.namespaceURI===F&&"tracked-changes"===a.localName)return!0;a=a.parentNode}return!1};this.isListItem=function(a){return"list-item"===(a&&a.localName)&&a.namespaceURI===F};this.isLineBreak=function(a){return"line-break"===(a&&a.localName)&&a.namespaceURI===F};this.isODFWhitespace=n;this.isGroupingElement=q;this.isCharacterElement=r;this.isAnchoredAsCharacterElement=m;this.isSpaceElement=f;this.firstChild=
c;this.lastChild=a;this.previousNode=e;this.nextNode=l;this.scanLeftForNonSpace=s;this.lookLeftForCharacter=function(a){var b,c=b=0;a.nodeType===Node.TEXT_NODE&&(c=a.length);0<c?(b=a.data,b=n(b.substr(c-1,1))?1===c?s(e(a))?2:0:n(b.substr(c-2,1))?0:2:1):m(a)&&(b=1);return b};this.lookRightForCharacter=function(a){var b=!1,c=0;a&&a.nodeType===Node.TEXT_NODE&&(c=a.length);0<c?b=!n(a.data.substr(0,1)):m(a)&&(b=!0);return b};this.scanLeftForAnyCharacter=function(b){var c=!1,d;for(b=b&&a(b);b;){d=b.nodeType===
Node.TEXT_NODE?b.length:0;if(0<d&&!n(b.data)){c=!0;break}if(m(b)){c=!0;break}b=e(b)}return c};this.scanRightForAnyCharacter=t;this.isTrailingWhitespace=y;this.isSignificantWhitespace=B;this.isDowngradableSpaceElement=function(a){return a.namespaceURI===F&&"s"===a.localName?s(e(a))&&t(l(a)):!1};this.getFirstNonWhitespaceChild=function(a){for(a=a&&a.firstChild;a&&a.nodeType===Node.TEXT_NODE&&N.test(a.nodeValue);)a=a.nextSibling;return a};this.parseLength=D;this.parseNonNegativeLength=v;this.parseFoFontSize=
function(a){var b;b=(b=D(a))&&(0>=b.value||"%"===b.unit)?null:b;return b||u(a)};this.parseFoLineHeight=function(a){return v(a)||u(a)};this.isTextContentContainingNode=w;this.getTextNodes=function(a,b){var c;c=G.getNodesInRange(a,function(a){var b=NodeFilter.FILTER_REJECT;a.nodeType===Node.TEXT_NODE?Boolean(h(a)&&(!n(a.textContent)||B(a,0)))&&(b=NodeFilter.FILTER_ACCEPT):w(a)&&(b=NodeFilter.FILTER_SKIP);return b},NodeFilter.SHOW_ELEMENT|NodeFilter.SHOW_TEXT);b||x(a,c);return c};this.getTextElements=
U;this.getParagraphElements=function(a){var b;b=G.getNodesInRange(a,function(a){var b=NodeFilter.FILTER_REJECT;if(d(a))b=NodeFilter.FILTER_ACCEPT;else if(w(a)||q(a))b=NodeFilter.FILTER_SKIP;return b},NodeFilter.SHOW_ELEMENT);E(a.startContainer,b,d);return b};this.getImageElements=function(a){var b;b=G.getNodesInRange(a,function(a){var b=NodeFilter.FILTER_SKIP;g(a)&&(b=NodeFilter.FILTER_ACCEPT);return b},NodeFilter.SHOW_ELEMENT);E(a.startContainer,b,g);return b};this.getHyperlinkElements=function(a){var b=
[],c=a.cloneRange();a.collapsed&&a.endContainer.nodeType===Node.ELEMENT_NODE&&(a=H(a.endContainer,a.endOffset),a.nodeType===Node.TEXT_NODE&&c.setEnd(a,1));U(c,!0,!1).forEach(function(a){for(a=a.parentNode;!d(a);){if(p(a)&&-1===b.indexOf(a)){b.push(a);break}a=a.parentNode}});c.detach();return b};this.convertToPx=T;this.sumLengths=function(a,b){var c=T(a),d=T(b);return c+d};this.getPageRect=function(a){for(var b=a;b&&(b.namespaceURI!==odf.Namespaces.officens||"body"!==b.localName&&"spreadsheet"!==b.localName)&&
(b.namespaceURI!==odf.Namespaces.drawns||"page"!==b.localName);)b=b.parentElement;return(b||a).getBoundingClientRect()}};
// Input 29
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.AnnotatableCanvas=function(){};gui.AnnotatableCanvas.prototype.refreshSize=function(){};gui.AnnotatableCanvas.prototype.getZoomLevel=function(){};gui.AnnotatableCanvas.prototype.getSizer=function(){};
gui.AnnotationViewManager=function(g,k,b,p){function d(a){var b=a.annotationEndElement,c=m.createRange(),d=a.getAttributeNS(odf.Namespaces.officens,"name");b&&(c.setStart(a,a.childNodes.length),c.setEnd(b,0),a=f.getTextNodes(c,!1),a.forEach(function(a){var b=m.createElement("span");b.className="annotationHighlight";b.setAttribute("annotation",d);a.parentNode.insertBefore(b,a);b.appendChild(a)}));c.detach()}function h(a){var d=g.getSizer();a?(b.style.display="inline-block",d.style.paddingRight=c.getComputedStyle(b).width):
(b.style.display="none",d.style.paddingRight=0);g.refreshSize()}function n(){r.sort(function(a,b){return 0!==(a.compareDocumentPosition(b)&Node.DOCUMENT_POSITION_FOLLOWING)?-1:1})}function q(){var a;for(a=0;a<r.length;a+=1){var c=r[a],d=c.parentNode,f=d.nextElementSibling,h=f.nextElementSibling,m=d.parentNode,n=0,n=r[r.indexOf(c)-1],k=void 0,c=g.getZoomLevel();d.style.left=(b.getBoundingClientRect().left-m.getBoundingClientRect().left)/c+"px";d.style.width=b.getBoundingClientRect().width/c+"px";f.style.width=
parseFloat(d.style.left)-30+"px";n&&(k=n.parentNode.getBoundingClientRect(),20>=(m.getBoundingClientRect().top-k.bottom)/c?d.style.top=Math.abs(m.getBoundingClientRect().top-k.bottom)/c+20+"px":d.style.top="0px");h.style.left=f.getBoundingClientRect().width/c+"px";var f=h.style,m=h.getBoundingClientRect().left/c,n=h.getBoundingClientRect().top/c,k=d.getBoundingClientRect().left/c,p=d.getBoundingClientRect().top/c,q=0,w=0,q=k-m,q=q*q,w=p-n,w=w*w,m=Math.sqrt(q+w);f.width=m+"px";n=Math.asin((d.getBoundingClientRect().top-
h.getBoundingClientRect().top)/(c*parseFloat(h.style.width)));h.style.transform="rotate("+n+"rad)";h.style.MozTransform="rotate("+n+"rad)";h.style.WebkitTransform="rotate("+n+"rad)";h.style.msTransform="rotate("+n+"rad)"}}var r=[],m=k.ownerDocument,f=new odf.OdfUtils,c=runtime.getWindow();runtime.assert(Boolean(c),"Expected to be run in an environment which has a global window, like a browser.");this.rerenderAnnotations=q;this.getMinimumHeightForAnnotationPane=function(){return"none"!==b.style.display&&
0<r.length?(r[r.length-1].parentNode.getBoundingClientRect().bottom-b.getBoundingClientRect().top)/g.getZoomLevel()+"px":null};this.addAnnotation=function(a){h(!0);r.push(a);n();var b=m.createElement("div"),c=m.createElement("div"),f=m.createElement("div"),g=m.createElement("div"),k;b.className="annotationWrapper";a.parentNode.insertBefore(b,a);c.className="annotationNote";c.appendChild(a);p&&(k=m.createElement("div"),k.className="annotationRemoveButton",c.appendChild(k));f.className="annotationConnector horizontal";
g.className="annotationConnector angular";b.appendChild(c);b.appendChild(f);b.appendChild(g);a.annotationEndElement&&d(a);q()};this.forgetAnnotations=function(){for(;r.length;){var a=r[0],b=r.indexOf(a),c=a.parentNode.parentNode;"div"===c.localName&&(c.parentNode.insertBefore(a,c),c.parentNode.removeChild(c));for(var a=a.getAttributeNS(odf.Namespaces.officens,"name"),a=m.querySelectorAll('span.annotationHighlight[annotation="'+a+'"]'),d=c=void 0,c=0;c<a.length;c+=1){for(d=a.item(c);d.firstChild;)d.parentNode.insertBefore(d.firstChild,
d);d.parentNode.removeChild(d)}-1!==b&&r.splice(b,1);0===r.length&&h(!1)}}};
// Input 30
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
(function(){function g(k,d,h,n,q){var r,m=0,f;for(f in k)if(k.hasOwnProperty(f)){if(m===h){r=f;break}m+=1}r?d.getPartData(k[r].href,function(c,a){if(c)runtime.log(c);else if(a){var e="@font-face { font-family: '"+(k[r].family||r)+"'; src: url(data:application/x-font-ttf;charset=binary;base64,"+b.convertUTF8ArrayToBase64(a)+') format("truetype"); }';try{n.insertRule(e,n.cssRules.length)}catch(l){runtime.log("Problem inserting rule in CSS: "+runtime.toJson(l)+"\nRule: "+e)}}else runtime.log("missing font data for "+
k[r].href);g(k,d,h+1,n,q)}):q&&q()}var k=xmldom.XPath,b=new core.Base64;odf.FontLoader=function(){this.loadFonts=function(b,d){for(var h=b.rootElement.fontFaceDecls;d.cssRules.length;)d.deleteRule(d.cssRules.length-1);if(h){var n={},q,r,m,f;if(h)for(h=k.getODFElementsWithXPath(h,"style:font-face[svg:font-face-src]",odf.Namespaces.lookupNamespaceURI),q=0;q<h.length;q+=1)r=h[q],m=r.getAttributeNS(odf.Namespaces.stylens,"name"),f=r.getAttributeNS(odf.Namespaces.svgns,"font-family"),r=k.getODFElementsWithXPath(r,
"svg:font-face-src/svg:font-face-uri",odf.Namespaces.lookupNamespaceURI),0<r.length&&(r=r[0].getAttributeNS(odf.Namespaces.xlinkns,"href"),n[m]={href:r,family:f});g(n,b,0,d)}}};return odf.FontLoader})();
// Input 31
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.Formatting=function(){function g(a){return(a=u[a])?v.mergeObjects({},a):{}}function k(a,b,c){for(a=a&&a.firstElementChild;a&&(a.namespaceURI!==b||a.localName!==c);)a=a.nextElementSibling;return a}function b(){for(var a=c.rootElement.fontFaceDecls,b={},d,f,a=a&&a.firstElementChild;a;){if(d=a.getAttributeNS(l,"name"))if((f=a.getAttributeNS(e,"font-family"))||0<a.getElementsByTagNameNS(e,"font-face-uri").length)b[d]=f;a=a.nextElementSibling}return b}function p(a){for(var b=c.rootElement.styles.firstElementChild;b;){if(b.namespaceURI===
l&&"default-style"===b.localName&&b.getAttributeNS(l,"family")===a)return b;b=b.nextElementSibling}return null}function d(a,b,d){var e,f,h;d=d||[c.rootElement.automaticStyles,c.rootElement.styles];for(h=0;h<d.length;h+=1)for(e=d[h],e=e.firstElementChild;e;){f=e.getAttributeNS(l,"name");if(e.namespaceURI===l&&"style"===e.localName&&e.getAttributeNS(l,"family")===b&&f===a||"list-style"===b&&e.namespaceURI===s&&"list-style"===e.localName&&f===a||"data"===b&&e.namespaceURI===t&&f===a)return e;e=e.nextElementSibling}return null}
function h(a){for(var b,c,d,e,f={},h=a.firstElementChild;h;){if(h.namespaceURI===l)for(d=f[h.nodeName]={},c=h.attributes,b=0;b<c.length;b+=1)e=c.item(b),d[e.name]=e.value;h=h.nextElementSibling}c=a.attributes;for(b=0;b<c.length;b+=1)e=c.item(b),f[e.name]=e.value;return f}function n(a,b){for(var e=c.rootElement.styles,f,m={},k=a.getAttributeNS(l,"family"),n=a;n;)f=h(n),m=v.mergeObjects(f,m),n=(f=n.getAttributeNS(l,"parent-style-name"))?d(f,k,[e]):null;if(n=p(k))f=h(n),m=v.mergeObjects(f,m);!1!==b&&
(f=g(k),m=v.mergeObjects(f,m));return m}function q(b,c){function d(a){Object.keys(a).forEach(function(b){Object.keys(a[b]).forEach(function(a){h+="|"+b+":"+a+"|"})})}for(var e=b.nodeType===Node.TEXT_NODE?b.parentNode:b,l,f=[],h="",g=!1;e;)!g&&B.isGroupingElement(e)&&(g=!0),(l=a.determineStylesForNode(e))&&f.push(l),e=e.parentNode;g&&(f.forEach(d),c&&(c[h]=f));return g?f:void 0}function r(a){var b={orderedStyles:[]};a.forEach(function(a){Object.keys(a).forEach(function(e){var f=Object.keys(a[e])[0],
h={name:f,family:e,displayName:void 0,isCommonStyle:!1},g;(g=d(f,e))?(e=n(g),b=v.mergeObjects(e,b),h.displayName=g.getAttributeNS(l,"display-name"),h.isCommonStyle=g.parentNode===c.rootElement.styles):runtime.log("No style element found for '"+f+"' of family '"+e+"'");b.orderedStyles.push(h)})});return b}function m(a,b){var c={},d=[];b||(b={});a.forEach(function(a){q(a,c)});Object.keys(c).forEach(function(a){b[a]||(b[a]=r(c[a]));d.push(b[a])});return d}function f(a,b){var c=B.parseLength(a),d=b;if(c)switch(c.unit){case "cm":d=
c.value;break;case "mm":d=0.1*c.value;break;case "in":d=2.54*c.value;break;case "pt":d=0.035277778*c.value;break;case "pc":case "px":case "em":break;default:runtime.log("Unit identifier: "+c.unit+" is not supported.")}return d}var c,a=new odf.StyleInfo,e=odf.Namespaces.svgns,l=odf.Namespaces.stylens,s=odf.Namespaces.textns,t=odf.Namespaces.numberns,y=odf.Namespaces.fons,B=new odf.OdfUtils,D=new core.DomUtils,v=new core.Utils,u={paragraph:{"style:paragraph-properties":{"fo:text-align":"left"}}};this.getSystemDefaultStyleAttributes=
g;this.setOdfContainer=function(a){c=a};this.getFontMap=b;this.getAvailableParagraphStyles=function(){for(var a=c.rootElement.styles,b,d,e=[],a=a&&a.firstElementChild;a;)"style"===a.localName&&a.namespaceURI===l&&(b=a.getAttributeNS(l,"family"),"paragraph"===b&&(b=a.getAttributeNS(l,"name"),d=a.getAttributeNS(l,"display-name")||b,b&&d&&e.push({name:b,displayName:d}))),a=a.nextElementSibling;return e};this.isStyleUsed=function(b){var d,e=c.rootElement;d=a.hasDerivedStyles(e,odf.Namespaces.lookupNamespaceURI,
b);b=(new a.UsedStyleList(e.styles)).uses(b)||(new a.UsedStyleList(e.automaticStyles)).uses(b)||(new a.UsedStyleList(e.body)).uses(b);return d||b};this.getDefaultStyleElement=p;this.getStyleElement=d;this.getStyleAttributes=h;this.getInheritedStyleAttributes=n;this.getFirstCommonParentStyleNameOrSelf=function(a){var b=c.rootElement.automaticStyles,e=c.rootElement.styles,f;for(f=d(a,"paragraph",[b]);f;)a=f.getAttributeNS(l,"parent-style-name"),f=d(a,"paragraph",[b]);return(f=d(a,"paragraph",[e]))?
a:null};this.hasParagraphStyle=function(a){return Boolean(d(a,"paragraph"))};this.getAppliedStyles=m;this.getAppliedStylesForElement=function(a,b){return m([a],b)[0]};this.updateStyle=function(a,d){var f,h;D.mapObjOntoNode(a,d,odf.Namespaces.lookupNamespaceURI);(f=d["style:text-properties"]&&d["style:text-properties"]["style:font-name"])&&!b().hasOwnProperty(f)&&(h=a.ownerDocument.createElementNS(l,"style:font-face"),h.setAttributeNS(l,"style:name",f),h.setAttributeNS(e,"svg:font-family",f),c.rootElement.fontFaceDecls.appendChild(h))};
this.createDerivedStyleObject=function(a,b,e){var l=d(a,b);runtime.assert(Boolean(l),"No style element found for '"+a+"' of family '"+b+"'");a=l.parentNode===c.rootElement.styles?{"style:parent-style-name":a}:h(l);a["style:family"]=b;v.mergeObjects(a,e);return a};this.getDefaultTabStopDistance=function(){for(var a=p("paragraph"),a=a&&a.firstElementChild,b;a;)a.namespaceURI===l&&"paragraph-properties"===a.localName&&(b=a.getAttributeNS(l,"tab-stop-distance")),a=a.nextElementSibling;b||(b="1.25cm");
return B.parseNonNegativeLength(b)};this.getContentSize=function(a,b){var e,h,g,m,n,p,q,r,s,t,u;a:{var B,v,L;e=d(a,b);runtime.assert("paragraph"===b||"table"===b,"styleFamily has to be either paragraph or table");if(e){B=e.getAttributeNS(l,"master-page-name")||"Standard";for(e=c.rootElement.masterStyles.lastElementChild;e&&e.getAttributeNS(l,"name")!==B;)e=e.previousElementSibling;B=e.getAttributeNS(l,"page-layout-name");v=D.getElementsByTagNameNS(c.rootElement.automaticStyles,l,"page-layout");for(L=
0;L<v.length;L+=1)if(e=v[L],e.getAttributeNS(l,"name")===B)break a}e=null}e||(e=k(c.rootElement.styles,l,"default-page-layout"));if(e=k(e,l,"page-layout-properties"))h=e.getAttributeNS(l,"print-orientation")||"portrait","portrait"===h?(h=21.001,g=29.7):(h=29.7,g=21.001),h=f(e.getAttributeNS(y,"page-width"),h),g=f(e.getAttributeNS(y,"page-height"),g),m=f(e.getAttributeNS(y,"margin"),null),null===m?(m=f(e.getAttributeNS(y,"margin-left"),2),n=f(e.getAttributeNS(y,"margin-right"),2),p=f(e.getAttributeNS(y,
"margin-top"),2),q=f(e.getAttributeNS(y,"margin-bottom"),2)):m=n=p=q=m,r=f(e.getAttributeNS(y,"padding"),null),null===r?(r=f(e.getAttributeNS(y,"padding-left"),0),s=f(e.getAttributeNS(y,"padding-right"),0),t=f(e.getAttributeNS(y,"padding-top"),0),u=f(e.getAttributeNS(y,"padding-bottom"),0)):r=s=t=u=r;return{width:h-m-n-r-s,height:g-p-q-t-u}}};
// Input 32
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.StyleTreeNode=function(g){this.derivedStyles={};this.element=g};
odf.Style2CSS=function(){function g(a){var b,c,d,e={};if(!a)return e;for(a=a.firstElementChild;a;){if(c=a.namespaceURI!==l||"style"!==a.localName&&"default-style"!==a.localName?a.namespaceURI===y&&"list-style"===a.localName?"list":a.namespaceURI!==l||"page-layout"!==a.localName&&"default-page-layout"!==a.localName?void 0:"page":a.getAttributeNS(l,"family"))(b=a.getAttributeNS(l,"name"))||(b=""),e.hasOwnProperty(c)?d=e[c]:e[c]=d={},d[b]=a;a=a.nextElementSibling}return e}function k(a,b){if(a.hasOwnProperty(b))return a[b];
var c,d=null;for(c in a)if(a.hasOwnProperty(c)&&(d=k(a[c].derivedStyles,b)))break;return d}function b(a,c,d){var e,f,h;if(!c.hasOwnProperty(a))return null;e=new odf.StyleTreeNode(c[a]);f=e.element.getAttributeNS(l,"parent-style-name");h=null;f&&(h=k(d,f)||b(f,c,d));h?h.derivedStyles[a]=e:d[a]=e;delete c[a];return e}function p(a,c){for(var d in a)a.hasOwnProperty(d)&&b(d,a,c)}function d(a,b,c){var e=[];c=c.derivedStyles;var l;var f=v[a],h;void 0===f?b=null:(h=b?"["+f+'|style-name="'+b+'"]':"","presentation"===
f&&(f="draw",h=b?'[presentation|style-name="'+b+'"]':""),b=f+"|"+u[a].join(h+","+f+"|")+h);null!==b&&e.push(b);for(l in c)c.hasOwnProperty(l)&&(b=d(a,l,c[l]),e=e.concat(b));return e}function h(a,b,c){for(a=a&&a.firstElementChild;a&&(a.namespaceURI!==b||a.localName!==c);)a=a.nextElementSibling;return a}function n(a,b){var c="",d,e,l;for(d=0;d<b.length;d+=1)if(e=b[d],l=a.getAttributeNS(e[0],e[1])){l=l.trim();if(G.hasOwnProperty(e[1])){var f=l.indexOf(" "),h=void 0,g=void 0;-1!==f?(h=l.substring(0,f),
g=l.substring(f)):(h=l,g="");(h=z.parseLength(h))&&"pt"===h.unit&&0.75>h.value&&(l="0.75pt"+g)}e[2]&&(c+=e[2]+":"+l+";")}return c}function q(b){return(b=h(b,l,"text-properties"))?z.parseFoFontSize(b.getAttributeNS(a,"font-size")):null}function r(a,b,c,d){return b+b+c+c+d+d}function m(b,c,d,e){c='text|list[text|style-name="'+c+'"]';var f=d.getAttributeNS(y,"level");d=h(d,l,"list-level-properties");d=h(d,l,"list-level-label-alignment");var g,m;d&&(g=d.getAttributeNS(a,"text-indent"),m=d.getAttributeNS(a,
"margin-left"));g||(g="-0.6cm");d="-"===g.charAt(0)?g.substring(1):"-"+g;for(f=f&&parseInt(f,10);1<f;)c+=" > text|list-item > text|list",f-=1;if(m){f=c+" > text|list-item > *:not(text|list):first-child";f+="{";f=f+("margin-left:"+m+";")+"}";try{b.insertRule(f,b.cssRules.length)}catch(n){runtime.log("cannot load rule: "+f)}}e=c+" > text|list-item > *:not(text|list):first-child:before{"+e+";";e=e+"counter-increment:list;"+("margin-left:"+g+";");e+="width:"+d+";";e+="display:inline-block}";try{b.insertRule(e,
b.cssRules.length)}catch(k){runtime.log("cannot load rule: "+e)}}function f(b,g,k,p){if("list"===g)for(var s=p.element.firstChild,u,v;s;){if(s.namespaceURI===y)if(u=s,"list-level-style-number"===s.localName){var G=u;v=G.getAttributeNS(l,"num-format");var S=G.getAttributeNS(l,"num-suffix")||"",G=G.getAttributeNS(l,"num-prefix")||"",M={1:"decimal",a:"lower-latin",A:"upper-latin",i:"lower-roman",I:"upper-roman"},Y="";G&&(Y+=' "'+G+'"');Y=M.hasOwnProperty(v)?Y+(" counter(list, "+M[v]+")"):v?Y+(' "'+v+
'"'):Y+" ''";v="content:"+Y+' "'+S+'"';m(b,k,u,v)}else"list-level-style-image"===s.localName?(v="content: none;",m(b,k,u,v)):"list-level-style-bullet"===s.localName&&(v="content: '"+u.getAttributeNS(y,"bullet-char")+"';",m(b,k,u,v));s=s.nextSibling}else if("page"===g){if(v=p.element,G=S=k="",s=h(v,l,"page-layout-properties"))if(u=v.getAttributeNS(l,"name"),k+=n(s,ba),(S=h(s,l,"background-image"))&&(G=S.getAttributeNS(B,"href"))&&(k=k+("background-image: url('odfkit:"+G+"');")+n(S,x)),"presentation"===
fa)for(v=(v=h(v.parentNode.parentNode,e,"master-styles"))&&v.firstElementChild;v;){if(v.namespaceURI===l&&"master-page"===v.localName&&v.getAttributeNS(l,"page-layout-name")===u){G=v.getAttributeNS(l,"name");S="draw|page[draw|master-page-name="+G+"] {"+k+"}";G="office|body, draw|page[draw|master-page-name="+G+"] {"+n(s,N)+" }";try{b.insertRule(S,b.cssRules.length),b.insertRule(G,b.cssRules.length)}catch(ia){throw ia;}}v=v.nextElementSibling}else if("text"===fa){S="office|text {"+k+"}";G="office|body {width: "+
s.getAttributeNS(a,"page-width")+";}";try{b.insertRule(S,b.cssRules.length),b.insertRule(G,b.cssRules.length)}catch(ja){throw ja;}}}else{k=d(g,k,p).join(",");s="";if(u=h(p.element,l,"text-properties")){G=u;v=Y="";S=1;u=""+n(G,w);M=G.getAttributeNS(l,"text-underline-style");"solid"===M&&(Y+=" underline");M=G.getAttributeNS(l,"text-line-through-style");"solid"===M&&(Y+=" line-through");Y.length&&(u+="text-decoration:"+Y+";");if(Y=G.getAttributeNS(l,"font-name")||G.getAttributeNS(a,"font-family"))M=
R[Y],u+="font-family: "+(M||Y)+";";M=G.parentNode;if(G=q(M)){for(;M;){if(G=q(M)){if("%"!==G.unit){v="font-size: "+G.value*S+G.unit+";";break}S*=G.value/100}G=M;Y=M="";M=null;"default-style"===G.localName?M=null:(M=G.getAttributeNS(l,"parent-style-name"),Y=G.getAttributeNS(l,"family"),M=K.getODFElementsWithXPath(ea,M?"//style:*[@style:name='"+M+"'][@style:family='"+Y+"']":"//style:default-style[@style:family='"+Y+"']",odf.Namespaces.lookupNamespaceURI)[0])}v||(v="font-size: "+parseFloat(L)*S+Q.getUnits(L)+
";");u+=v}s+=u}if(u=h(p.element,l,"paragraph-properties"))v=u,u=""+n(v,U),(S=h(v,l,"background-image"))&&(G=S.getAttributeNS(B,"href"))&&(u=u+("background-image: url('odfkit:"+G+"');")+n(S,x)),(v=v.getAttributeNS(a,"line-height"))&&"normal"!==v&&(v=z.parseFoLineHeight(v),u="%"!==v.unit?u+("line-height: "+v.value+v.unit+";"):u+("line-height: "+v.value/100+";")),s+=u;if(u=h(p.element,l,"graphic-properties"))G=u,u=""+n(G,E),v=G.getAttributeNS(c,"opacity"),S=G.getAttributeNS(c,"fill"),G=G.getAttributeNS(c,
"fill-color"),"solid"===S||"hatch"===S?G&&"none"!==G?(v=isNaN(parseFloat(v))?1:parseFloat(v)/100,S=G.replace(/^#?([a-f\d])([a-f\d])([a-f\d])$/i,r),(G=(S=/^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(S))?{r:parseInt(S[1],16),g:parseInt(S[2],16),b:parseInt(S[3],16)}:null)&&(u+="background-color: rgba("+G.r+","+G.g+","+G.b+","+v+");")):u+="background: none;":"none"===S&&(u+="background: none;"),s+=u;if(u=h(p.element,l,"drawing-page-properties"))v=""+n(u,E),"true"===u.getAttributeNS(D,"background-visible")&&
(v+="background: none;"),s+=v;if(u=h(p.element,l,"table-cell-properties"))u=""+n(u,H),s+=u;if(u=h(p.element,l,"table-row-properties"))u=""+n(u,F),s+=u;if(u=h(p.element,l,"table-column-properties"))u=""+n(u,T),s+=u;if(u=h(p.element,l,"table-properties"))v=u,u=""+n(v,Z),v=v.getAttributeNS(t,"border-model"),"collapsing"===v?u+="border-collapse:collapse;":"separating"===v&&(u+="border-collapse:separate;"),s+=u;if(0!==s.length)try{b.insertRule(k+"{"+s+"}",b.cssRules.length)}catch(ca){throw ca;}}for(var da in p.derivedStyles)p.derivedStyles.hasOwnProperty(da)&&
f(b,g,da,p.derivedStyles[da])}var c=odf.Namespaces.drawns,a=odf.Namespaces.fons,e=odf.Namespaces.officens,l=odf.Namespaces.stylens,s=odf.Namespaces.svgns,t=odf.Namespaces.tablens,y=odf.Namespaces.textns,B=odf.Namespaces.xlinkns,D=odf.Namespaces.presentationns,v={graphic:"draw","drawing-page":"draw",paragraph:"text",presentation:"presentation",ruby:"text",section:"text",table:"table","table-cell":"table","table-column":"table","table-row":"table",text:"text",list:"text",page:"office"},u={graphic:"circle connected control custom-shape ellipse frame g line measure page page-thumbnail path polygon polyline rect regular-polygon".split(" "),
paragraph:"alphabetical-index-entry-template h illustration-index-entry-template index-source-style object-index-entry-template p table-index-entry-template table-of-content-entry-template user-index-entry-template".split(" "),presentation:"caption circle connector control custom-shape ellipse frame g line measure page-thumbnail path polygon polyline rect regular-polygon".split(" "),"drawing-page":"caption circle connector control page custom-shape ellipse frame g line measure page-thumbnail path polygon polyline rect regular-polygon".split(" "),
ruby:["ruby","ruby-text"],section:"alphabetical-index bibliography illustration-index index-title object-index section table-of-content table-index user-index".split(" "),table:["background","table"],"table-cell":"body covered-table-cell even-columns even-rows first-column first-row last-column last-row odd-columns odd-rows table-cell".split(" "),"table-column":["table-column"],"table-row":["table-row"],text:"a index-entry-chapter index-entry-link-end index-entry-link-start index-entry-page-number index-entry-span index-entry-tab-stop index-entry-text index-title-template linenumbering-configuration list-level-style-number list-level-style-bullet outline-level-style span".split(" "),
list:["list-item"]},w=[[a,"color","color"],[a,"background-color","background-color"],[a,"font-weight","font-weight"],[a,"font-style","font-style"]],x=[[l,"repeat","background-repeat"]],U=[[a,"background-color","background-color"],[a,"text-align","text-align"],[a,"text-indent","text-indent"],[a,"padding","padding"],[a,"padding-left","padding-left"],[a,"padding-right","padding-right"],[a,"padding-top","padding-top"],[a,"padding-bottom","padding-bottom"],[a,"border-left","border-left"],[a,"border-right",
"border-right"],[a,"border-top","border-top"],[a,"border-bottom","border-bottom"],[a,"margin","margin"],[a,"margin-left","margin-left"],[a,"margin-right","margin-right"],[a,"margin-top","margin-top"],[a,"margin-bottom","margin-bottom"],[a,"border","border"]],E=[[a,"background-color","background-color"],[a,"min-height","min-height"],[c,"stroke","border"],[s,"stroke-color","border-color"],[s,"stroke-width","border-width"],[a,"border","border"],[a,"border-left","border-left"],[a,"border-right","border-right"],
[a,"border-top","border-top"],[a,"border-bottom","border-bottom"]],H=[[a,"background-color","background-color"],[a,"border-left","border-left"],[a,"border-right","border-right"],[a,"border-top","border-top"],[a,"border-bottom","border-bottom"],[a,"border","border"]],T=[[l,"column-width","width"]],F=[[l,"row-height","height"],[a,"keep-together",null]],Z=[[l,"width","width"],[a,"margin-left","margin-left"],[a,"margin-right","margin-right"],[a,"margin-top","margin-top"],[a,"margin-bottom","margin-bottom"]],
ba=[[a,"background-color","background-color"],[a,"padding","padding"],[a,"padding-left","padding-left"],[a,"padding-right","padding-right"],[a,"padding-top","padding-top"],[a,"padding-bottom","padding-bottom"],[a,"border","border"],[a,"border-left","border-left"],[a,"border-right","border-right"],[a,"border-top","border-top"],[a,"border-bottom","border-bottom"],[a,"margin","margin"],[a,"margin-left","margin-left"],[a,"margin-right","margin-right"],[a,"margin-top","margin-top"],[a,"margin-bottom",
"margin-bottom"]],N=[[a,"page-width","width"],[a,"page-height","height"]],G={border:!0,"border-left":!0,"border-right":!0,"border-top":!0,"border-bottom":!0,"stroke-width":!0},R={},z=new odf.OdfUtils,fa,ea,L,K=xmldom.XPath,Q=new core.CSSUnits;this.style2css=function(a,b,c,d,e){for(var l,h,m,k;b.cssRules.length;)b.deleteRule(b.cssRules.length-1);l=null;d&&(l=d.ownerDocument,ea=d.parentNode);e&&(l=e.ownerDocument,ea=e.parentNode);if(l)for(k in odf.Namespaces.forEachPrefix(function(a,c){h="@namespace "+
a+" url("+c+");";try{b.insertRule(h,b.cssRules.length)}catch(d){}}),R=c,fa=a,L=runtime.getWindow().getComputedStyle(document.body,null).getPropertyValue("font-size")||"12pt",a=g(d),d=g(e),e={},v)if(v.hasOwnProperty(k))for(m in c=e[k]={},p(a[k],c),p(d[k],c),c)c.hasOwnProperty(m)&&f(b,k,m,c[m])}};
// Input 33
/*

 Copyright (C) 2014 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.TextLayout=function(){function g(b,g,d){var h=Math.ceil((g.childElementCount-1)/2),h=Math.ceil((d-(h*b.pageHeight+(h-1)*b.pageSeparation))/b.pageHeight);d=!1;if(0<h){d=!0;for(var k=g.ownerDocument,q=k.createDocumentFragment(),r=k.documentElement.namespaceURI,m=Math.ceil((g.childElementCount-1)/2),f=g.lastElementChild,c=b.pageHeight-b.marginTop-b.marginBottom,a,h=h+m;m<h;)a=k.createElementNS(r,"div"),a.style.width="100%",a.style.cssFloat="right",a.style.position="relative",a.style.zIndex=10,a.style.marginBottom=
b.marginTop+"px",0<m&&(a.style.height=b.pageSeparation+"px",a.style.marginTop=b.marginBottom+"px",a.style.background=b.background),q.appendChild(a),a=k.createElementNS(r,"div"),a.style.height=c+"px",a.style.width="1px",a.style.cssFloat="right",q.appendChild(a),m+=1;a=k.createElementNS(r,"div");a.style.width="100%";a.style.cssFloat="right";a.style.position="relative";a.style.zIndex=10;a.style.marginTop=b.marginBottom+"px";q.appendChild(a);f?g.replaceChild(q,f):g.appendChild(q)}else if(0>h){d=!0;b=
-h;for(h=g.lastElementChild;0<b;){g.removeChild(h);if(h=g.lastElementChild)g.removeChild(h),h=g.lastElementChild;b-=1}h.style.marginBottom=0;h.style.height=0}return d}function k(b,k,d,h){b=b.body.lastElementChild;h=(new Date).getTime()+h;b=b.clientHeight;for(var n=!0;n&&g(k,d,b);)n=h,n=(new Date).getTime()<n;return n}this.layout=function(b,g,d,h){h||(h={pageHeight:980,marginTop:20,marginBottom:20,pageSeparation:10,background:"grey"});k(b,h,g,d);k(b,h,g,d);return 0<d}};
// Input 34
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.Canvas=function(){};ops.Canvas.prototype.getZoomLevel=function(){};ops.Canvas.prototype.getElement=function(){};
// Input 35
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
(function(){function g(){function a(d){c=!0;runtime.setTimeout(function(){try{d()}catch(e){runtime.log(String(e))}c=!1;0<b.length&&a(b.pop())},10)}var b=[],c=!1;this.clearQueue=function(){b.length=0};this.addToQueue=function(d){if(0===b.length&&!c)return a(d);b.push(d)}}function k(a){function b(){for(;0<c.cssRules.length;)c.deleteRule(0);c.insertRule("#shadowContent draw|page {display:none;}",0);c.insertRule("office|presentation draw|page {display:none;}",1);c.insertRule("#shadowContent draw|page:nth-of-type("+
d+") {display:block;}",2);c.insertRule("office|presentation draw|page:nth-of-type("+d+") {display:block;}",3)}var c=a.sheet,d=1;this.showFirstPage=function(){d=1;b()};this.showNextPage=function(){d+=1;b()};this.showPreviousPage=function(){1<d&&(d-=1,b())};this.showPage=function(a){0<a&&(d=a,b())};this.css=a;this.destroy=function(b){a.parentNode.removeChild(a);b()}}function b(a){for(;a.firstChild;)a.removeChild(a.firstChild)}function p(a){a=a.sheet;for(var b=a.cssRules;b.length;)a.deleteRule(b.length-
1)}function d(a,b,c){(new odf.Style2CSS).style2css(a.getDocumentType(),c.sheet,b.getFontMap(),a.rootElement.styles,a.rootElement.automaticStyles)}function h(a,b,c){var d=null;a=a.rootElement.body.getElementsByTagNameNS(E,c+"-decl");c=b.getAttributeNS(E,"use-"+c+"-name");var e;if(c&&0<a.length)for(b=0;b<a.length;b+=1)if(e=a[b],e.getAttributeNS(E,"name")===c){d=e.textContent;break}return d}function n(a,c,d,e){var l=a.ownerDocument;c=a.getElementsByTagNameNS(c,d);for(a=0;a<c.length;a+=1)b(c[a]),e&&(d=
c[a],d.appendChild(l.createTextNode(e)))}function q(a,b,c,d){c.setAttributeNS("urn:webodf:names:helper","styleid",b);var e,l=c.getAttributeNS(w,"anchor-type")||"paragraph",f=c.getAttributeNS(t,"style-name");e=c.getAttributeNS(v,"x");var h=c.getAttributeNS(v,"y"),g=c.getAttributeNS(v,"width"),m=c.getAttributeNS(v,"height"),k=c.getAttributeNS(y,"min-height"),n=c.getAttributeNS(y,"min-width");if("as-char"===l)e="display: inline-block;";else{a=Z.getStyleProperties(a.styles,a.automaticStyles,f,"graphic",
{style:{"vertical-pos":null,"vertical-rel":null,"horizontal-pos":null,"horizontal-rel":null}}).style;var f=e,p=a["horizontal-pos"],q=a["horizontal-rel"];e=c.parentElement.getBoundingClientRect();l=0;if("from-left"===p||"from-inside"===p)l=F.convertToPx(f||0);"page"===q&&(f=F.getPageRect(c),e&&(l-=e.left),f&&(l+=f.left));e=l;l=a["vertical-pos"];p=a["vertical-rel"];a=c.parentElement.getBoundingClientRect();f=0;"from-top"===l&&(f=F.convertToPx(h||0));"page"===p&&(h=F.getPageRect(c),a&&(f-=a.top),h&&
(f+=h.top));e="position: absolute;"+("left: "+e+"px;")+("top: "+f+"px;")}g&&(e+="width: "+g+";");m&&(e+="height: "+m+";");k&&(e+="min-height: "+k+";");n&&(e+="min-width: "+n+";");e&&(e="draw|"+c.localName+'[webodfhelper|styleid="'+b+'"] {'+e+"}",d.insertRule(e,d.cssRules.length))}function r(a){for(a=a.firstChild;a;){if(a.namespaceURI===B&&"binary-data"===a.localName)return"data:image/png;base64,"+a.textContent.replace(/[\r\n\s]/g,"");a=a.nextSibling}return""}function m(a,b,c,d){function e(b){b&&(b=
'draw|image[webodfhelper|styleid="'+a+'"] {'+("background-image: url("+b+");")+"}",d.insertRule(b,d.cssRules.length))}function l(a){e(a.url)}c.setAttributeNS("urn:webodf:names:helper","styleid",a);var f=c.getAttributeNS(x,"href"),h;if(f)try{h=b.getPart(f),h.onchange=l,h.load()}catch(g){runtime.log("slight problem: "+String(g))}else f=r(c),e(f)}function f(a){var b=a.ownerDocument;N.getElementsByTagNameNS(a,w,"line-break").forEach(function(a){a.hasChildNodes()||a.appendChild(b.createElement("br"))})}
function c(a){var b=a.ownerDocument;N.getElementsByTagNameNS(a,w,"s").forEach(function(a){for(var c,d;a.firstChild;)a.removeChild(a.firstChild);a.appendChild(b.createTextNode(" "));d=parseInt(a.getAttributeNS(w,"c"),10);if(1<d)for(a.removeAttributeNS(w,"c"),c=1;c<d;c+=1)a.parentNode.insertBefore(a.cloneNode(!0),a)})}function a(a){N.getElementsByTagNameNS(a,w,"tab").forEach(function(a){a.textContent="\t"})}function e(a,b){function c(a,d){var l=h.documentElement.namespaceURI;"video/"===d.substr(0,6)?
(e=h.createElementNS(l,"video"),e.setAttribute("controls","controls"),f=h.createElementNS(l,"source"),a&&f.setAttribute("src",a),f.setAttribute("type",d),e.appendChild(f),b.parentNode.appendChild(e)):b.innerHtml="Unrecognised Plugin"}function d(a){c(a.url,a.mimetype)}var e,f,l,h=b.ownerDocument,g;if(l=b.getAttributeNS(x,"href"))try{g=a.getPart(l),g.onchange=d,g.load()}catch(m){runtime.log("slight problem: "+String(m))}else runtime.log("using MP4 data fallback"),l=r(b),c(l,"video/mp4")}function l(a){var b=
a.getElementsByTagName("head")[0],c,d;c=a.styleSheets.length;for(d=b.firstElementChild;d&&("style"!==d.localName||!d.hasAttribute("webodfcss"));)d=d.nextElementSibling;if(d)return c=parseInt(d.getAttribute("webodfcss"),10),d.setAttribute("webodfcss",c+1),d;"string"===String(typeof webodf_css)?c=webodf_css:(d="webodf.css",runtime.currentDirectory&&(d=runtime.currentDirectory(),0<d.length&&"/"!==d.substr(-1)&&(d+="/"),d+="../webodf.css"),c=runtime.readFileSync(d,"utf-8"));d=a.createElementNS(b.namespaceURI,
"style");d.setAttribute("media","screen, print, handheld, projection");d.setAttribute("type","text/css");d.setAttribute("webodfcss","1");d.appendChild(a.createTextNode(c));b.appendChild(d);return d}function s(a){var b=a.getElementsByTagName("head")[0],c=a.createElementNS(b.namespaceURI,"style"),d="";c.setAttribute("type","text/css");c.setAttribute("media","screen, print, handheld, projection");odf.Namespaces.forEachPrefix(function(a,b){d+="@namespace "+a+" url("+b+");\n"});d+="@namespace webodfhelper url(urn:webodf:names:helper);\n";
c.appendChild(a.createTextNode(d));b.appendChild(c);return c}var t=odf.Namespaces.drawns,y=odf.Namespaces.fons,B=odf.Namespaces.officens,D=odf.Namespaces.stylens,v=odf.Namespaces.svgns,u=odf.Namespaces.tablens,w=odf.Namespaces.textns,x=odf.Namespaces.xlinkns,U=odf.Namespaces.xmlns,E=odf.Namespaces.presentationns,H=runtime.getWindow(),T=xmldom.XPath,F=new odf.OdfUtils,Z=new odf.StyleInfo,ba=new odf.TextLayout,N=new core.DomUtils;odf.OdfCanvas=function(r){function x(a,b,c){function d(a,b,c,e){la.addToQueue(function(){m(a,
b,c,e)})}var e,l;e=b.getElementsByTagNameNS(t,"image");for(b=0;b<e.length;b+=1)l=e.item(b),d("image"+String(b),a,l,c)}function y(a,b){function c(a,b){la.addToQueue(function(){e(a,b)})}var d,l,f;l=b.getElementsByTagNameNS(t,"plugin");for(d=0;d<l.length;d+=1)f=l.item(d),c(a,f)}function v(){var a;O.firstChild&&(1<aa?(O.style.MozTransformOrigin="center top",O.style.WebkitTransformOrigin="center top",O.style.OTransformOrigin="center top",O.style.msTransformOrigin="center top"):(O.style.MozTransformOrigin=
"left top",O.style.WebkitTransformOrigin="left top",O.style.OTransformOrigin="left top",O.style.msTransformOrigin="left top"),O.style.WebkitTransform="scale("+aa+")",O.style.MozTransform="scale("+aa+")",O.style.OTransform="scale("+aa+")",O.style.msTransform="scale("+aa+")",M&&((a=M.getMinimumHeightForAnnotationPane())?O.style.minHeight=a:O.style.removeProperty("min-height")),r.style.width=Math.round(aa*O.offsetWidth)+"px",r.style.height=Math.round(aa*O.offsetHeight)+"px")}function Z(a){na?($.parentNode||
O.appendChild($),M&&M.forgetAnnotations(),M=new gui.AnnotationViewManager(Q,a.body,$,S),N.getElementsByTagNameNS(a.body,B,"annotation").forEach(M.addAnnotation),M.rerenderAnnotations(),v()):$.parentNode&&(O.removeChild($),M.forgetAnnotations(),v())}function L(e){function l(){p(ia);p(ja);p(ca);b(r);r.style.display="inline-block";var g=I.rootElement;r.ownerDocument.importNode(g,!0);J.setOdfContainer(I);var m=I,k=ia;(new odf.FontLoader).loadFonts(m,k.sheet);d(I,J,ja);k=I;m=ca.sheet;b(r);O=ga.createElementNS(r.namespaceURI,
"div");O.style.display="inline-block";O.style.background="white";O.appendChild(g);r.appendChild(O);$=ga.createElementNS(r.namespaceURI,"div");$.id="annotationsPane";da=ga.createElementNS(r.namespaceURI,"div");da.id="shadowContent";da.style.position="absolute";da.style.top=0;da.style.left=0;k.getContentElement().appendChild(da);var s,X=g.body,C=[],A;for(s=X.firstElementChild;s&&s!==X;)if(s.namespaceURI===t&&(C[C.length]=s),s.firstElementChild)s=s.firstElementChild;else{for(;s&&s!==X&&!s.nextElementSibling;)s=
s.parentNode;s&&s.nextElementSibling&&(s=s.nextElementSibling)}for(A=0;A<C.length;A+=1)s=C[A],q(g,"frame"+String(A),s,m);C=T.getODFElementsWithXPath(X,".//*[*[@text:anchor-type='paragraph']]",odf.Namespaces.lookupNamespaceURI);for(X=0;X<C.length;X+=1)s=C[X],s.setAttributeNS&&s.setAttributeNS("urn:webodf:names:helper","containsparagraphanchor",!0);ha=ga.createElementNS(r.namespaceURI,"div");k.getContentElement().parentNode.insertBefore(ha,k.getContentElement());ba.layout(g,ha,100);s=da;var K,L,N;N=
0;var Q,M,C=k.rootElement.ownerDocument;if((X=g.body.firstElementChild)&&X.namespaceURI===B&&("presentation"===X.localName||"drawing"===X.localName))for(X=X.firstElementChild;X;){A=X.getAttributeNS(t,"master-page-name");if(A){for(K=k.rootElement.masterStyles.firstElementChild;K&&(K.getAttributeNS(D,"name")!==A||"master-page"!==K.localName||K.namespaceURI!==D);)K=K.nextElementSibling;A=K}else A=null;if(A){K=X.getAttributeNS("urn:webodf:names:helper","styleid");L=C.createElementNS(t,"draw:page");M=
A.firstElementChild;for(Q=0;M;)"true"!==M.getAttributeNS(E,"placeholder")&&(N=M.cloneNode(!0),L.appendChild(N),q(g,K+"_"+Q,N,m)),M=M.nextElementSibling,Q+=1;M=Q=N=void 0;var S=L.getElementsByTagNameNS(t,"frame");for(N=0;N<S.length;N+=1)Q=S[N],(M=Q.getAttributeNS(E,"class"))&&!/^(date-time|footer|header|page-number)$/.test(M)&&Q.parentNode.removeChild(Q);s.appendChild(L);N=String(s.getElementsByTagNameNS(t,"page").length);n(L,w,"page-number",N);n(L,E,"header",h(k,X,"header"));n(L,E,"footer",h(k,X,
"footer"));q(g,K,L,m);L.setAttributeNS(t,"draw:master-page-name",A.getAttributeNS(D,"name"))}X=X.nextElementSibling}s=r.namespaceURI;C=g.body.getElementsByTagNameNS(u,"table-cell");for(X=0;X<C.length;X+=1)A=C.item(X),A.hasAttributeNS(u,"number-columns-spanned")&&A.setAttributeNS(s,"colspan",A.getAttributeNS(u,"number-columns-spanned")),A.hasAttributeNS(u,"number-rows-spanned")&&A.setAttributeNS(s,"rowspan",A.getAttributeNS(u,"number-rows-spanned"));f(g.body);c(g.body);a(g.body);x(k,g.body,m);y(k,
g.body);A=g.body;var k=r.namespaceURI,X={},C={},W;K=H.document.getElementsByTagNameNS(w,"list-style");for(s=0;s<K.length;s+=1)Q=K.item(s),(M=Q.getAttributeNS(D,"name"))&&(C[M]=Q);A=A.getElementsByTagNameNS(w,"list");for(s=0;s<A.length;s+=1)if(Q=A.item(s),K=Q.getAttributeNS(U,"id")){L=Q.getAttributeNS(w,"continue-list");Q.setAttributeNS(k,"id",K);N="text|list#"+K+" > text|list-item > *:first-child:before {";if(M=Q.getAttributeNS(w,"style-name")){Q=C[M];W=F.getFirstNonWhitespaceChild(Q);Q=void 0;if(W)if("list-level-style-number"===
W.localName){Q=W.getAttributeNS(D,"num-format");M=W.getAttributeNS(D,"num-suffix")||"";var S="",S={1:"decimal",a:"lower-latin",A:"upper-latin",i:"lower-roman",I:"upper-roman"},V=void 0,V=W.getAttributeNS(D,"num-prefix")||"",V=S.hasOwnProperty(Q)?V+(" counter(list, "+S[Q]+")"):Q?V+("'"+Q+"';"):V+" ''";M&&(V+=" '"+M+"'");Q=S="content: "+V+";"}else"list-level-style-image"===W.localName?Q="content: none;":"list-level-style-bullet"===W.localName&&(Q="content: '"+W.getAttributeNS(w,"bullet-char")+"';");
W=Q}if(L){for(Q=X[L];Q;)Q=X[Q];N+="counter-increment:"+L+";";W?(W=W.replace("list",L),N+=W):N+="content:counter("+L+");"}else L="",W?(W=W.replace("list",K),N+=W):N+="content: counter("+K+");",N+="counter-increment:"+K+";",m.insertRule("text|list#"+K+" {counter-reset:"+K+"}",m.cssRules.length);N+="}";X[K]=L;N&&m.insertRule(N,m.cssRules.length)}O.insertBefore(da,O.firstChild);v();Z(g);if(!e&&(g=[I],P.hasOwnProperty("statereadychange")))for(m=P.statereadychange,W=0;W<m.length;W+=1)m[W].apply(null,g)}
I.state===odf.OdfContainer.DONE?l():(runtime.log("WARNING: refreshOdf called but ODF was not DONE."),A=runtime.setTimeout(function oa(){I.state===odf.OdfContainer.DONE?l():(runtime.log("will be back later..."),A=runtime.setTimeout(oa,500))},100))}function K(a){la.clearQueue();r.innerHTML=runtime.tr("Loading")+" "+a+"...";r.removeAttribute("style");I=new odf.OdfContainer(a,function(a){I=a;L(!1)})}runtime.assert(null!==r&&void 0!==r,"odf.OdfCanvas constructor needs DOM element");runtime.assert(null!==
r.ownerDocument&&void 0!==r.ownerDocument,"odf.OdfCanvas constructor needs DOM");var Q=this,ga=r.ownerDocument,W=new core.Async,I,J=new odf.Formatting,V,O=null,$=null,na=!1,S=!1,M=null,Y,ia,ja,ca,da,ha,aa=1,P={},A,C,ka=!1,ma=!1,la=new g;this.refreshCSS=function(){ka=!0;C.trigger()};this.refreshSize=function(){C.trigger()};this.odfContainer=function(){return I};this.setOdfContainer=function(a,b){I=a;L(!0===b)};this.load=this.load=K;this.save=function(a){I.save(a)};this.addListener=function(a,b){switch(a){case "click":var c=
r,d=a;c.addEventListener?c.addEventListener(d,b,!1):c.attachEvent?c.attachEvent("on"+d,b):c["on"+d]=b;break;default:c=P.hasOwnProperty(a)?P[a]:P[a]=[],b&&-1===c.indexOf(b)&&c.push(b)}};this.getFormatting=function(){return J};this.getAnnotationViewManager=function(){return M};this.refreshAnnotations=function(){Z(I.rootElement)};this.rerenderAnnotations=function(){M&&(ma=!0,C.trigger())};this.getSizer=function(){return O};this.enableAnnotations=function(a,b){a!==na&&(na=a,S=b,I&&Z(I.rootElement))};
this.addAnnotation=function(a){M&&(M.addAnnotation(a),v())};this.forgetAnnotations=function(){M&&(M.forgetAnnotations(),v())};this.setZoomLevel=function(a){aa=a;v()};this.getZoomLevel=function(){return aa};this.fitToContainingElement=function(a,b){var c=r.offsetHeight/aa;aa=a/(r.offsetWidth/aa);b/c<aa&&(aa=b/c);v()};this.fitToWidth=function(a){aa=a/(r.offsetWidth/aa);v()};this.fitSmart=function(a,b){var c,d;c=r.offsetWidth/aa;d=r.offsetHeight/aa;c=a/c;void 0!==b&&b/d<c&&(c=b/d);aa=Math.min(1,c);v()};
this.fitToHeight=function(a){aa=a/(r.offsetHeight/aa);v()};this.showFirstPage=function(){V.showFirstPage()};this.showNextPage=function(){V.showNextPage()};this.showPreviousPage=function(){V.showPreviousPage()};this.showPage=function(a){V.showPage(a);v()};this.getElement=function(){return r};this.addCssForFrameWithImage=function(a){var b=a.getAttributeNS(t,"name"),c=a.firstElementChild;q(I.rootElement,b,a,ca.sheet);c&&m(b+"img",I,c,ca.sheet)};this.destroy=function(a){var b=ga.getElementsByTagName("head")[0],
c=[V.destroy,C.destroy];runtime.clearTimeout(A);$&&$.parentNode&&$.parentNode.removeChild($);O&&(r.removeChild(O),O=null);var d=Y,e=parseInt(d.getAttribute("webodfcss"),10);1===e?d.parentNode.removeChild(d):d.setAttribute("count",e-1);b.removeChild(ia);b.removeChild(ja);b.removeChild(ca);W.destroyAll(c,a)};Y=l(ga);V=new k(s(ga));ia=s(ga);ja=s(ga);ca=s(ga);C=new core.ScheduledTask(function(){ka&&(d(I,J,ja),ka=!1);ma&&(M&&M.rerenderAnnotations(),ma=!1);v()},0)}})();
// Input 36
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.MemberProperties=function(){};
ops.Member=function(g,k){var b=new ops.MemberProperties;this.getMemberId=function(){return g};this.getProperties=function(){return b};this.setProperties=function(g){Object.keys(g).forEach(function(d){b[d]=g[d]})};this.removeProperties=function(g){Object.keys(g).forEach(function(d){"fullName"!==d&&"color"!==d&&"imageUrl"!==d&&b.hasOwnProperty(d)&&delete b[d]})};runtime.assert(Boolean(g),"No memberId was supplied!");k.fullName||(k.fullName=runtime.tr("Unknown Author"));k.color||(k.color="black");k.imageUrl||
(k.imageUrl="avatar-joe.png");b=k};
// Input 37
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.SelectionMover=function(g,k){function b(){f.setUnfilteredPosition(g.getNode(),0);return f}function p(a,b){var c,d=null;a&&0<a.length&&(c=b?a.item(a.length-1):a.item(0));c&&(d={top:c.top,left:b?c.right:c.left,bottom:c.bottom});return d}function d(a,b,c,f){var h=a.nodeType;c.setStart(a,b);c.collapse(!f);f=p(c.getClientRects(),!0===f);!f&&0<b&&(c.setStart(a,b-1),c.setEnd(a,b),f=p(c.getClientRects(),!0));f||(h===Node.ELEMENT_NODE&&0<b&&a.childNodes.length>=b?f=d(a,b-1,c,!0):a.nodeType===Node.TEXT_NODE&&
0<b?f=d(a,b-1,c,!0):a.previousSibling?f=d(a.previousSibling,a.previousSibling.nodeType===Node.TEXT_NODE?a.previousSibling.textContent.length:a.previousSibling.childNodes.length,c,!0):a.parentNode&&a.parentNode!==k?f=d(a.parentNode,0,c,!1):(c.selectNode(k),f=p(c.getClientRects(),!1)));runtime.assert(Boolean(f),"No visible rectangle found");return f}function h(a,d,f){for(var h=b(),g=new core.LoopWatchDog(1E4),m=0,k=0;0<a&&h.nextPosition();)g.check(),f.acceptPosition(h)===c&&(m+=1,d.acceptPosition(h)===
c&&(k+=m,m=0,a-=1));return k}function n(a,d,f){for(var h=b(),g=new core.LoopWatchDog(1E4),m=0,k=0;0<a&&h.previousPosition();)g.check(),f.acceptPosition(h)===c&&(m+=1,d.acceptPosition(h)===c&&(k+=m,m=0,a-=1));return k}function q(a,e){var f=b(),h=0,g=0,m=0>a?-1:1;for(a=Math.abs(a);0<a;){for(var n=e,p=m,q=f,r=q.container(),w=0,x=null,U=void 0,E=10,H=void 0,T=0,F=void 0,Z=void 0,ba=void 0,H=void 0,N=k.ownerDocument.createRange(),G=new core.LoopWatchDog(1E4),H=d(r,q.unfilteredDomOffset(),N),F=H.top,Z=
H.left,ba=F;!0===(0>p?q.previousPosition():q.nextPosition());)if(G.check(),n.acceptPosition(q)===c&&(w+=1,r=q.container(),H=d(r,q.unfilteredDomOffset(),N),H.top!==F)){if(H.top!==ba&&ba!==F)break;ba=H.top;H=Math.abs(Z-H.left);if(null===x||H<E)x=r,U=q.unfilteredDomOffset(),E=H,T=w}null!==x?(q.setUnfilteredPosition(x,U),w=T):w=0;N.detach();h+=w;if(0===h)break;g+=h;a-=1}return g*m}function r(a,e){var f,h,g,n,p=b(),q=m.getParagraphElement(p.getCurrentNode()),r=0,u=k.ownerDocument.createRange();0>a?(f=
p.previousPosition,h=-1):(f=p.nextPosition,h=1);for(g=d(p.container(),p.unfilteredDomOffset(),u);f.call(p);)if(e.acceptPosition(p)===c){if(m.getParagraphElement(p.getCurrentNode())!==q)break;n=d(p.container(),p.unfilteredDomOffset(),u);if(n.bottom!==g.bottom&&(g=n.top>=g.top&&n.bottom<g.bottom||n.top<=g.top&&n.bottom>g.bottom,!g))break;r+=h;g=n}u.detach();return r}var m=new odf.OdfUtils,f,c=core.PositionFilter.FilterResult.FILTER_ACCEPT;this.getStepCounter=function(){return{convertForwardStepsBetweenFilters:h,
convertBackwardStepsBetweenFilters:n,countLinesSteps:q,countStepsToLineBoundary:r}};(function(){f=gui.SelectionMover.createPositionIterator(k);var a=k.ownerDocument.createRange();a.setStart(f.container(),f.unfilteredDomOffset());a.collapse(!0);g.setSelectedRange(a)})()};
gui.SelectionMover.createPositionIterator=function(g){var k=new function(){this.acceptNode=function(b){return b&&"urn:webodf:names:cursor"!==b.namespaceURI&&"urn:webodf:names:editinfo"!==b.namespaceURI?NodeFilter.FILTER_ACCEPT:NodeFilter.FILTER_REJECT}};return new core.PositionIterator(g,5,k,!1)};(function(){return gui.SelectionMover})();
// Input 38
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.Document=function(){};ops.Document.prototype.getMemberIds=function(){};ops.Document.prototype.removeCursor=function(g){};ops.Document.prototype.getDocumentElement=function(){};ops.Document.prototype.getRootNode=function(){};ops.Document.prototype.getDOMDocument=function(){};ops.Document.prototype.cloneDocumentElement=function(){};ops.Document.prototype.setDocumentElement=function(g){};ops.Document.prototype.subscribe=function(g,k){};ops.Document.prototype.unsubscribe=function(g,k){};
ops.Document.prototype.getCanvas=function(){};ops.Document.prototype.createRootFilter=function(g){};ops.Document.signalCursorAdded="cursor/added";ops.Document.signalCursorRemoved="cursor/removed";ops.Document.signalCursorMoved="cursor/moved";ops.Document.signalMemberAdded="member/added";ops.Document.signalMemberUpdated="member/updated";ops.Document.signalMemberRemoved="member/removed";
// Input 39
ops.OdtCursor=function(g,k){var b=this,p={},d,h,n,q=new core.EventNotifier([ops.OdtCursor.signalCursorUpdated]);this.removeFromDocument=function(){n.remove()};this.subscribe=function(b,d){q.subscribe(b,d)};this.unsubscribe=function(b,d){q.unsubscribe(b,d)};this.getStepCounter=function(){return h.getStepCounter()};this.getMemberId=function(){return g};this.getNode=function(){return n.getNode()};this.getAnchorNode=function(){return n.getAnchorNode()};this.getSelectedRange=function(){return n.getSelectedRange()};
this.setSelectedRange=function(d,h){n.setSelectedRange(d,h);q.emit(ops.OdtCursor.signalCursorUpdated,b)};this.hasForwardSelection=function(){return n.hasForwardSelection()};this.getDocument=function(){return k};this.getSelectionType=function(){return d};this.setSelectionType=function(b){p.hasOwnProperty(b)?d=b:runtime.log("Invalid selection type: "+b)};this.resetSelectionType=function(){b.setSelectionType(ops.OdtCursor.RangeSelection)};n=new core.Cursor(k.getDOMDocument(),g);h=new gui.SelectionMover(n,
k.getRootNode());p[ops.OdtCursor.RangeSelection]=!0;p[ops.OdtCursor.RegionSelection]=!0;b.resetSelectionType()};ops.OdtCursor.RangeSelection="Range";ops.OdtCursor.RegionSelection="Region";ops.OdtCursor.signalCursorUpdated="cursorUpdated";(function(){return ops.OdtCursor})();
// Input 40
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.Operation=function(){};ops.Operation.prototype.init=function(g){};ops.Operation.prototype.execute=function(g){};ops.Operation.prototype.spec=function(){};
// Input 41
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
(function(){function g(b,g,d){function h(a,b){this.steps=a;this.node=b;this.setIteratorPosition=function(a){a.setPositionBeforeElement(b);do if(g.acceptPosition(a)===s)break;while(a.nextPosition())}}function n(a){var b="";a.nodeType===Node.ELEMENT_NODE&&(b=a.getAttributeNS(m,"nodeId"));return b}function q(a){var b=k.toString();a.setAttributeNS(m,"nodeId",b);k+=1;return b}function r(a){for(var d,e=null;!e&&a&&a!==b;)(d=n(a))&&(e=c[d])&&e.node!==a&&(runtime.log("Cloned node detected. Creating new bookmark"),
e=null,a.removeAttributeNS(m,"nodeId")),a=a.parentNode;return e}var m="urn:webodf:names:steps",f={},c={},a=new odf.OdfUtils,e=new core.DomUtils,l,s=core.PositionFilter.FilterResult.FILTER_ACCEPT;this.updateCache=function(b,e,l){var g,m;m=e.getCurrentNode();e.isBeforeNode()&&a.isParagraph(m)&&(g=!0,l||(b+=1));g&&(e=n(m)||q(m),(l=c[e])?l.node===m?l.steps=b:(runtime.log("Cloned node detected. Creating new bookmark"),e=q(m),l=c[e]=new h(b,m)):l=c[e]=new h(b,m),e=l,m=Math.ceil(e.steps/d)*d,b=f[m],!b||
e.steps>b.steps)&&(f[m]=e)};this.setToClosestStep=function(a,b){for(var c=Math.floor(a/d)*d,e;!e&&0!==c;)e=f[c],c-=d;e=e||l;e.setIteratorPosition(b);return e.steps};this.setToClosestDomPoint=function(a,c,d){var e,h;if(a===b&&0===c)e=l;else if(a===b&&c===b.childNodes.length)for(h in e=l,f)f.hasOwnProperty(h)&&(a=f[h],a.steps>e.steps&&(e=a));else if(e=r(a.childNodes.item(c)||a),!e)for(d.setUnfilteredPosition(a,c);!e&&d.previousNode();)e=r(d.getCurrentNode());e=e||l;e.setIteratorPosition(d);return e.steps};
this.updateCacheAtPoint=function(a,l){var h=[],g={},m,k;for(m in c)c.hasOwnProperty(m)&&(k=c[m],k.steps>a&&h.push(k));h.forEach(function(a){var h=Math.ceil(a.steps/d)*d,m,k;if(e.containsNode(b,a.node)){if(a.steps=l(a.steps),m=Math.ceil(a.steps/d)*d,k=g[m],!k||a.steps>k.steps)g[m]=a}else delete c[n(a.node)];f[h]===a&&delete f[h]});Object.keys(g).forEach(function(a){f[a]=g[a]})};l=new function(a,b){this.steps=a;this.node=b;this.setIteratorPosition=function(a){a.setUnfilteredPosition(b,0);do if(g.acceptPosition(a)===
s)break;while(a.nextPosition())}}(0,b)}var k=0;ops.StepsTranslator=function(b,k,d,h){function n(){var a=b();a!==r&&(runtime.log("Undo detected. Resetting steps cache"),r=a,m=new g(r,d,h),c=k(r))}function q(b,c){if(!c||d.acceptPosition(b)===a)return!0;for(;b.previousPosition();)if(d.acceptPosition(b)===a){if(c(0,b.container(),b.unfilteredDomOffset()))return!0;break}for(;b.nextPosition();)if(d.acceptPosition(b)===a){if(c(1,b.container(),b.unfilteredDomOffset()))return!0;break}return!1}var r=b(),m=new g(r,
d,h),f=new core.DomUtils,c=k(b()),a=core.PositionFilter.FilterResult.FILTER_ACCEPT;this.convertStepsToDomPoint=function(b){var f,h;if(isNaN(b))throw new TypeError("Requested steps is not numeric ("+b+")");if(0>b)throw new RangeError("Requested steps is negative ("+b+")");n();for(f=m.setToClosestStep(b,c);f<b&&c.nextPosition();)(h=d.acceptPosition(c)===a)&&(f+=1),m.updateCache(f,c,h);if(f!==b)throw new RangeError("Requested steps ("+b+") exceeds available steps ("+f+")");return{node:c.container(),
offset:c.unfilteredDomOffset()}};this.convertDomPointToSteps=function(b,l,h){var g;n();f.containsNode(r,b)||(l=0>f.comparePoints(r,0,b,l),b=r,l=l?0:r.childNodes.length);c.setUnfilteredPosition(b,l);q(c,h)||c.setUnfilteredPosition(b,l);h=c.container();l=c.unfilteredDomOffset();b=m.setToClosestDomPoint(h,l,c);if(0>f.comparePoints(c.container(),c.unfilteredDomOffset(),h,l))return 0<b?b-1:b;for(;(c.container()!==h||c.unfilteredDomOffset()!==l)&&c.nextPosition();)(g=d.acceptPosition(c)===a)&&(b+=1),m.updateCache(b,
c,g);return b+0};this.prime=function(){var b,f;n();for(b=m.setToClosestStep(0,c);c.nextPosition();)(f=d.acceptPosition(c)===a)&&(b+=1),m.updateCache(b,c,f)};this.handleStepsInserted=function(a){n();m.updateCacheAtPoint(a.position,function(b){return b+a.length})};this.handleStepsRemoved=function(a){n();m.updateCacheAtPoint(a.position,function(b){b-=a.length;0>b&&(b=0);return b})}};ops.StepsTranslator.PREVIOUS_STEP=0;ops.StepsTranslator.NEXT_STEP=1;return ops.StepsTranslator})();
// Input 42
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.TextPositionFilter=function(g){function k(d,g,m){var f,c;if(g){if(b.isInlineRoot(g)&&b.isGroupingElement(m))return n;f=b.lookLeftForCharacter(g);if(1===f||2===f&&(b.scanRightForAnyCharacter(m)||b.scanRightForAnyCharacter(b.nextNode(d))))return h}f=null===g&&b.isParagraph(d);c=b.lookRightForCharacter(m);if(f)return c?h:b.scanRightForAnyCharacter(m)?n:h;if(!c)return n;g=g||b.previousNode(d);return b.scanLeftForAnyCharacter(g)?n:h}var b=new odf.OdfUtils,p=Node.ELEMENT_NODE,d=Node.TEXT_NODE,h=core.PositionFilter.FilterResult.FILTER_ACCEPT,
n=core.PositionFilter.FilterResult.FILTER_REJECT;this.acceptPosition=function(q){var r=q.container(),m=r.nodeType,f,c,a;if(m!==p&&m!==d)return n;if(m===d){if(!b.isGroupingElement(r.parentNode)||b.isWithinTrackedChanges(r.parentNode,g()))return n;m=q.unfilteredDomOffset();f=r.data;runtime.assert(m!==f.length,"Unexpected offset.");if(0<m){q=f[m-1];if(!b.isODFWhitespace(q))return h;if(1<m)if(q=f[m-2],!b.isODFWhitespace(q))c=h;else{if(!b.isODFWhitespace(f.substr(0,m)))return n}else a=b.previousNode(r),
b.scanLeftForNonSpace(a)&&(c=h);if(c===h)return b.isTrailingWhitespace(r,m)?n:h;c=f[m];return b.isODFWhitespace(c)?n:b.scanLeftForAnyCharacter(b.previousNode(r))?n:h}a=q.leftNode();c=r;r=r.parentNode;c=k(r,a,c)}else!b.isGroupingElement(r)||b.isWithinTrackedChanges(r,g())?c=n:(a=q.leftNode(),c=q.rightNode(),c=k(r,a,c));return c}};
// Input 43
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OdtDocument=function(g){function k(){var a=g.odfContainer().getContentElement(),b=a&&a.localName;runtime.assert("text"===b,"Unsupported content element type '"+b+"' for OdtDocument");return a}function b(){return c.getDocumentElement().ownerDocument}function p(a){for(;a&&!(a.namespaceURI===odf.Namespaces.officens&&"text"===a.localName||a.namespaceURI===odf.Namespaces.officens&&"annotation"===a.localName);)a=a.parentNode;return a}function d(a){this.acceptPosition=function(b){b=b.container();var c;
c="string"===typeof a?l[a].getNode():a;return p(b)===p(c)?y:B}}function h(a,b,c,d){d=gui.SelectionMover.createPositionIterator(d);var e;1===c.length?e=c[0]:(e=new core.PositionFilterChain,c.forEach(e.addFilter));c=new core.StepIterator(e,d);c.setPosition(a,b);return c}function n(a){var b=gui.SelectionMover.createPositionIterator(k());a=v.convertStepsToDomPoint(a);b.setUnfilteredPosition(a.node,a.offset);return b}function q(b){return a.getParagraphElement(b)}function r(a,b){return g.getFormatting().getStyleElement(a,
b)}function m(a){return r(a,"paragraph")}function f(a,b,c){a=a.childNodes.item(b)||a;return(a=q(a))&&e.containsNode(c,a)?a:c}var c=this,a,e,l={},s={},t=new core.EventNotifier([ops.Document.signalMemberAdded,ops.Document.signalMemberUpdated,ops.Document.signalMemberRemoved,ops.Document.signalCursorAdded,ops.Document.signalCursorRemoved,ops.Document.signalCursorMoved,ops.OdtDocument.signalParagraphChanged,ops.OdtDocument.signalParagraphStyleModified,ops.OdtDocument.signalCommonStyleCreated,ops.OdtDocument.signalCommonStyleDeleted,
ops.OdtDocument.signalTableAdded,ops.OdtDocument.signalOperationStart,ops.OdtDocument.signalOperationEnd,ops.OdtDocument.signalProcessingBatchStart,ops.OdtDocument.signalProcessingBatchEnd,ops.OdtDocument.signalUndoStackChanged,ops.OdtDocument.signalStepsInserted,ops.OdtDocument.signalStepsRemoved]),y=core.PositionFilter.FilterResult.FILTER_ACCEPT,B=core.PositionFilter.FilterResult.FILTER_REJECT,D,v,u;this.getDocumentElement=function(){return g.odfContainer().rootElement};this.getDOMDocument=function(){return this.getDocumentElement().ownerDocument};
this.cloneDocumentElement=function(){var a=c.getDocumentElement(),b=g.getAnnotationViewManager();b&&b.forgetAnnotations();a=a.cloneNode(!0);g.refreshAnnotations();return a};this.setDocumentElement=function(a){var b=g.odfContainer();b.setRootElement(a);g.setOdfContainer(b,!0);g.refreshCSS()};this.getDOMDocument=b;this.getRootElement=p;this.createStepIterator=h;this.getIteratorAtPosition=n;this.convertDomPointToCursorStep=function(a,b,c){return v.convertDomPointToSteps(a,b,c)};this.convertDomToCursorRange=
function(a,b){var c,d;c=b&&b(a.anchorNode,a.anchorOffset);c=v.convertDomPointToSteps(a.anchorNode,a.anchorOffset,c);b||a.anchorNode!==a.focusNode||a.anchorOffset!==a.focusOffset?(d=b&&b(a.focusNode,a.focusOffset),d=v.convertDomPointToSteps(a.focusNode,a.focusOffset,d)):d=c;return{position:c,length:d-c}};this.convertCursorToDomRange=function(a,c){var d=b().createRange(),e,f;e=v.convertStepsToDomPoint(a);c?(f=v.convertStepsToDomPoint(a+c),0<c?(d.setStart(e.node,e.offset),d.setEnd(f.node,f.offset)):
(d.setStart(f.node,f.offset),d.setEnd(e.node,e.offset))):d.setStart(e.node,e.offset);return d};this.getStyleElement=r;this.upgradeWhitespacesAtPosition=function(b){b=n(b);var c,d,e;b.previousPosition();b.previousPosition();for(e=-1;1>=e;e+=1){c=b.container();d=b.unfilteredDomOffset();if(c.nodeType===Node.TEXT_NODE&&" "===c.data[d]&&a.isSignificantWhitespace(c,d)){runtime.assert(" "===c.data[d],"upgradeWhitespaceToElement: textNode.data[offset] should be a literal space");var f=c.ownerDocument.createElementNS(odf.Namespaces.textns,
"text:s");f.appendChild(c.ownerDocument.createTextNode(" "));c.deleteData(d,1);0<d&&(c=c.splitText(d));c.parentNode.insertBefore(f,c);c=f;b.moveToEndOfNode(c)}b.nextPosition()}};this.downgradeWhitespacesAtPosition=function(b){var c=n(b),d;b=c.container();for(c=c.unfilteredDomOffset();!a.isSpaceElement(b)&&b.childNodes.item(c);)b=b.childNodes.item(c),c=0;b.nodeType===Node.TEXT_NODE&&(b=b.parentNode);a.isDowngradableSpaceElement(b)&&(c=b.firstChild,d=b.lastChild,e.mergeIntoParent(b),d!==c&&e.normalizeTextNodes(d),
e.normalizeTextNodes(c))};this.getParagraphStyleElement=m;this.getParagraphElement=q;this.getParagraphStyleAttributes=function(a){return(a=m(a))?g.getFormatting().getInheritedStyleAttributes(a,!1):null};this.getTextNodeAtStep=function(a,d){var e=n(a),f=e.container(),h,g=0,m=null;f.nodeType===Node.TEXT_NODE?(h=f,g=e.unfilteredDomOffset(),0<h.length&&(0<g&&(h=h.splitText(g)),h.parentNode.insertBefore(b().createTextNode(""),h),h=h.previousSibling,g=0)):(h=b().createTextNode(""),g=0,f.insertBefore(h,
e.rightNode()));if(d){if(l[d]&&c.getCursorPosition(d)===a){for(m=l[d].getNode();m.nextSibling&&"cursor"===m.nextSibling.localName;)m.parentNode.insertBefore(m.nextSibling,m);0<h.length&&h.nextSibling!==m&&(h=b().createTextNode(""),g=0);m.parentNode.insertBefore(h,m)}}else for(;h.nextSibling&&"cursor"===h.nextSibling.localName;)h.parentNode.insertBefore(h.nextSibling,h);for(;h.previousSibling&&h.previousSibling.nodeType===Node.TEXT_NODE;)e=h.previousSibling,e.appendData(h.data),g=e.length,h=e,h.parentNode.removeChild(h.nextSibling);
for(;h.nextSibling&&h.nextSibling.nodeType===Node.TEXT_NODE;)e=h.nextSibling,h.appendData(e.data),h.parentNode.removeChild(e);return{textNode:h,offset:g}};this.fixCursorPositions=function(){Object.keys(l).forEach(function(a){var b=l[a],d=p(b.getNode()),e=c.createRootFilter(d),g,m,k,n=!1;k=b.getSelectedRange();g=f(k.startContainer,k.startOffset,d);m=h(k.startContainer,k.startOffset,[D,e],g);k.collapsed?d=m:(g=f(k.endContainer,k.endOffset,d),d=h(k.endContainer,k.endOffset,[D,e],g));m.isStep()&&d.isStep()?
m.container()!==d.container()||m.offset()!==d.offset()||k.collapsed&&b.getAnchorNode()===b.getNode()||(n=!0,k.setStart(m.container(),m.offset()),k.collapse(!0)):(n=!0,runtime.assert(m.roundToClosestStep(),"No walkable step found for cursor owned by "+a),k.setStart(m.container(),m.offset()),runtime.assert(d.roundToClosestStep(),"No walkable step found for cursor owned by "+a),k.setEnd(d.container(),d.offset()));n&&(b.setSelectedRange(k,b.hasForwardSelection()),c.emit(ops.Document.signalCursorMoved,
b))})};this.getCursorPosition=function(a){return(a=l[a])?v.convertDomPointToSteps(a.getNode(),0):0};this.getCursorSelection=function(a){a=l[a];var b=0,c=0;a&&(b=v.convertDomPointToSteps(a.getNode(),0),c=v.convertDomPointToSteps(a.getAnchorNode(),0));return{position:c,length:b-c}};this.getPositionFilter=function(){return D};this.getOdfCanvas=function(){return g};this.getCanvas=function(){return g};this.getRootNode=k;this.addMember=function(a){runtime.assert(void 0===s[a.getMemberId()],"This member already exists");
s[a.getMemberId()]=a};this.getMember=function(a){return s.hasOwnProperty(a)?s[a]:null};this.removeMember=function(a){delete s[a]};this.getCursor=function(a){return l[a]};this.getMemberIds=function(){var a=[],b;for(b in l)l.hasOwnProperty(b)&&a.push(l[b].getMemberId());return a};this.addCursor=function(a){runtime.assert(Boolean(a),"OdtDocument::addCursor without cursor");var b=a.getMemberId(),d=c.convertCursorToDomRange(0,0);runtime.assert("string"===typeof b,"OdtDocument::addCursor has cursor without memberid");
runtime.assert(!l[b],"OdtDocument::addCursor is adding a duplicate cursor with memberid "+b);a.setSelectedRange(d,!0);l[b]=a};this.removeCursor=function(a){var b=l[a];return b?(b.removeFromDocument(),delete l[a],c.emit(ops.Document.signalCursorRemoved,a),!0):!1};this.moveCursor=function(a,b,d,e){a=l[a];b=c.convertCursorToDomRange(b,d);a&&(a.setSelectedRange(b,0<=d),a.setSelectionType(e||ops.OdtCursor.RangeSelection))};this.getFormatting=function(){return g.getFormatting()};this.emit=function(a,b){t.emit(a,
b)};this.subscribe=function(a,b){t.subscribe(a,b)};this.unsubscribe=function(a,b){t.unsubscribe(a,b)};this.createRootFilter=function(a){return new d(a)};this.close=function(a){a()};this.destroy=function(a){a()};D=new ops.TextPositionFilter(k);a=new odf.OdfUtils;e=new core.DomUtils;v=new ops.StepsTranslator(k,gui.SelectionMover.createPositionIterator,D,500);t.subscribe(ops.OdtDocument.signalStepsInserted,v.handleStepsInserted);t.subscribe(ops.OdtDocument.signalStepsRemoved,v.handleStepsRemoved);t.subscribe(ops.OdtDocument.signalOperationEnd,
function(a){var b=a.spec(),d=b.memberid,b=(new Date(b.timestamp)).toISOString(),e=g.odfContainer();a.isEdit&&(d=c.getMember(d).getProperties().fullName,e.setMetadata({"dc:creator":d,"dc:date":b},null),u||(e.incrementEditingCycles(),e.setMetadata(null,["meta:editing-duration","meta:document-statistic"])),u=a)})};ops.OdtDocument.signalParagraphChanged="paragraph/changed";ops.OdtDocument.signalTableAdded="table/added";ops.OdtDocument.signalCommonStyleCreated="style/created";
ops.OdtDocument.signalCommonStyleDeleted="style/deleted";ops.OdtDocument.signalParagraphStyleModified="paragraphstyle/modified";ops.OdtDocument.signalOperationStart="operation/start";ops.OdtDocument.signalOperationEnd="operation/end";ops.OdtDocument.signalProcessingBatchStart="router/batchstart";ops.OdtDocument.signalProcessingBatchEnd="router/batchend";ops.OdtDocument.signalUndoStackChanged="undo/changed";ops.OdtDocument.signalStepsInserted="steps/inserted";ops.OdtDocument.signalStepsRemoved="steps/removed";
(function(){return ops.OdtDocument})();
// Input 44
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpAddAnnotation=function(){function g(b,d,h){var f=b.getTextNodeAtStep(h,k);f&&(b=f.textNode,h=b.parentNode,f.offset!==b.length&&b.splitText(f.offset),h.insertBefore(d,b.nextSibling),0===b.length&&h.removeChild(b))}var k,b,p,d,h,n;this.init=function(g){k=g.memberid;b=parseInt(g.timestamp,10);p=parseInt(g.position,10);d=parseInt(g.length,10)||0;h=g.name};this.isEdit=!0;this.group=void 0;this.execute=function(q){var r=q.getCursor(k),m,f;f=new core.DomUtils;n=q.getDOMDocument();var c=new Date(b),
a,e,l,s;a=n.createElementNS(odf.Namespaces.officens,"office:annotation");a.setAttributeNS(odf.Namespaces.officens,"office:name",h);m=n.createElementNS(odf.Namespaces.dcns,"dc:creator");m.setAttributeNS("urn:webodf:names:editinfo","editinfo:memberid",k);m.textContent=q.getMember(k).getProperties().fullName;e=n.createElementNS(odf.Namespaces.dcns,"dc:date");e.appendChild(n.createTextNode(c.toISOString()));c=n.createElementNS(odf.Namespaces.textns,"text:list");l=n.createElementNS(odf.Namespaces.textns,
"text:list-item");s=n.createElementNS(odf.Namespaces.textns,"text:p");l.appendChild(s);c.appendChild(l);a.appendChild(m);a.appendChild(e);a.appendChild(c);d&&(m=n.createElementNS(odf.Namespaces.officens,"office:annotation-end"),m.setAttributeNS(odf.Namespaces.officens,"office:name",h),a.annotationEndElement=m,g(q,m,p+d));g(q,a,p);q.emit(ops.OdtDocument.signalStepsInserted,{position:p,length:d});r&&(m=n.createRange(),f=f.getElementsByTagNameNS(a,odf.Namespaces.textns,"p")[0],m.selectNodeContents(f),
r.setSelectedRange(m,!1),q.emit(ops.Document.signalCursorMoved,r));q.getOdfCanvas().addAnnotation(a);q.fixCursorPositions();return!0};this.spec=function(){return{optype:"AddAnnotation",memberid:k,timestamp:b,position:p,length:d,name:h}}};
// Input 45
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpAddCursor=function(){var g,k;this.init=function(b){g=b.memberid;k=b.timestamp};this.isEdit=!1;this.group=void 0;this.execute=function(b){var k=b.getCursor(g);if(k)return!1;k=new ops.OdtCursor(g,b);b.addCursor(k);b.emit(ops.Document.signalCursorAdded,k);return!0};this.spec=function(){return{optype:"AddCursor",memberid:g,timestamp:k}}};
// Input 46
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpAddMember=function(){var g,k,b;this.init=function(p){g=p.memberid;k=parseInt(p.timestamp,10);b=p.setProperties};this.isEdit=!1;this.group=void 0;this.execute=function(k){var d;if(k.getMember(g))return!1;d=new ops.Member(g,b);k.addMember(d);k.emit(ops.Document.signalMemberAdded,d);return!0};this.spec=function(){return{optype:"AddMember",memberid:g,timestamp:k,setProperties:b}}};
// Input 47
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpAddStyle=function(){var g,k,b,p,d,h,n=odf.Namespaces.stylens;this.init=function(n){g=n.memberid;k=n.timestamp;b=n.styleName;p=n.styleFamily;d="true"===n.isAutomaticStyle||!0===n.isAutomaticStyle;h=n.setProperties};this.isEdit=!0;this.group=void 0;this.execute=function(g){var k=g.getOdfCanvas().odfContainer(),m=g.getFormatting(),f=g.getDOMDocument().createElementNS(n,"style:style");if(!f)return!1;h&&m.updateStyle(f,h);f.setAttributeNS(n,"style:family",p);f.setAttributeNS(n,"style:name",b);d?
k.rootElement.automaticStyles.appendChild(f):k.rootElement.styles.appendChild(f);g.getOdfCanvas().refreshCSS();d||g.emit(ops.OdtDocument.signalCommonStyleCreated,{name:b,family:p});return!0};this.spec=function(){return{optype:"AddStyle",memberid:g,timestamp:k,styleName:b,styleFamily:p,isAutomaticStyle:d,setProperties:h}}};
// Input 48
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.ObjectNameGenerator=function(g,k){function b(a,b){var c={};this.generateName=function(){var d=b(),e=0,f;do f=a+e,e+=1;while(c[f]||d[f]);c[f]=!0;return f}}function p(){var a={};[g.rootElement.automaticStyles,g.rootElement.styles].forEach(function(b){for(b=b.firstElementChild;b;)b.namespaceURI===d&&"style"===b.localName&&(a[b.getAttributeNS(d,"name")]=!0),b=b.nextElementSibling});return a}var d=odf.Namespaces.stylens,h=odf.Namespaces.drawns,n=odf.Namespaces.xlinkns,q=new core.DomUtils,r=(new core.Utils).hashString(k),
m=null,f=null,c=null,a={},e={};this.generateStyleName=function(){null===m&&(m=new b("auto"+r+"_",function(){return p()}));return m.generateName()};this.generateFrameName=function(){null===f&&(q.getElementsByTagNameNS(g.rootElement.body,h,"frame").forEach(function(b){a[b.getAttributeNS(h,"name")]=!0}),f=new b("fr"+r+"_",function(){return a}));return f.generateName()};this.generateImageName=function(){null===c&&(q.getElementsByTagNameNS(g.rootElement.body,h,"image").forEach(function(a){a=a.getAttributeNS(n,
"href");a=a.substring(9,a.lastIndexOf("."));e[a]=!0}),c=new b("img"+r+"_",function(){return e}));return c.generateName()}};
// Input 49
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.TextStyleApplicator=function(g,k,b){function p(b){function d(a,b){return"object"===typeof a&&"object"===typeof b?Object.keys(a).every(function(c){return d(a[c],b[c])}):a===b}var c={};this.isStyleApplied=function(a){a=k.getAppliedStylesForElement(a,c);return d(b,a)}}function d(d){var f={};this.applyStyleToContainer=function(c){var a;a=c.getAttributeNS(q,"style-name");var e=c.ownerDocument;a=a||"";if(!f.hasOwnProperty(a)){var l=a,h;h=a?k.createDerivedStyleObject(a,"text",d):d;e=e.createElementNS(r,
"style:style");k.updateStyle(e,h);e.setAttributeNS(r,"style:name",g.generateStyleName());e.setAttributeNS(r,"style:family","text");e.setAttributeNS("urn:webodf:names:scope","scope","document-content");b.appendChild(e);f[l]=e}a=f[a].getAttributeNS(r,"name");c.setAttributeNS(q,"text:style-name",a)}}function h(b,d){var c=b.ownerDocument,a=b.parentNode,e,l,h=new core.LoopWatchDog(1E4);l=[];"span"!==a.localName||a.namespaceURI!==q?(e=c.createElementNS(q,"text:span"),a.insertBefore(e,b),a=!1):(b.previousSibling&&
!n.rangeContainsNode(d,a.firstChild)?(e=a.cloneNode(!1),a.parentNode.insertBefore(e,a.nextSibling)):e=a,a=!0);l.push(b);for(c=b.nextSibling;c&&n.rangeContainsNode(d,c);)h.check(),l.push(c),c=c.nextSibling;l.forEach(function(a){a.parentNode!==e&&e.appendChild(a)});if(c&&a)for(l=e.cloneNode(!1),e.parentNode.insertBefore(l,e.nextSibling);c;)h.check(),a=c.nextSibling,l.appendChild(c),c=a;return e}var n=new core.DomUtils,q=odf.Namespaces.textns,r=odf.Namespaces.stylens;this.applyStyle=function(b,f,c){var a=
{},e,l,g,k;runtime.assert(c&&c.hasOwnProperty("style:text-properties"),"applyStyle without any text properties");a["style:text-properties"]=c["style:text-properties"];g=new d(a);k=new p(a);b.forEach(function(a){e=k.isStyleApplied(a);!1===e&&(l=h(a,f),g.applyStyleToContainer(l))})}};
// Input 50
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpApplyDirectStyling=function(){function g(b,d,f){var c=b.getOdfCanvas().odfContainer(),a=q.splitBoundaries(d),e=n.getTextNodes(d,!1);d={startContainer:d.startContainer,startOffset:d.startOffset,endContainer:d.endContainer,endOffset:d.endOffset};(new odf.TextStyleApplicator(new odf.ObjectNameGenerator(c,k),b.getFormatting(),c.rootElement.automaticStyles)).applyStyle(e,d,f);a.forEach(q.normalizeTextNodes)}var k,b,p,d,h,n=new odf.OdfUtils,q=new core.DomUtils;this.init=function(g){k=g.memberid;b=
g.timestamp;p=parseInt(g.position,10);d=parseInt(g.length,10);h=g.setProperties};this.isEdit=!0;this.group=void 0;this.execute=function(q){var m=q.convertCursorToDomRange(p,d),f=n.getParagraphElements(m);g(q,m,h);m.detach();q.getOdfCanvas().refreshCSS();q.fixCursorPositions();f.forEach(function(c){q.emit(ops.OdtDocument.signalParagraphChanged,{paragraphElement:c,memberId:k,timeStamp:b})});q.getOdfCanvas().rerenderAnnotations();return!0};this.spec=function(){return{optype:"ApplyDirectStyling",memberid:k,
timestamp:b,position:p,length:d,setProperties:h}}};
// Input 51
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpApplyHyperlink=function(){function g(b){for(;b;){if(q.isHyperlink(b))return!0;b=b.parentNode}return!1}var k,b,p,d,h,n=new core.DomUtils,q=new odf.OdfUtils;this.init=function(g){k=g.memberid;b=g.timestamp;p=g.position;d=g.length;h=g.hyperlink};this.isEdit=!0;this.group=void 0;this.execute=function(r){var m=r.getDOMDocument(),f=r.convertCursorToDomRange(p,d),c=n.splitBoundaries(f),a=[],e=q.getTextNodes(f,!1);if(0===e.length)return!1;e.forEach(function(b){var c=q.getParagraphElement(b);runtime.assert(!1===
g(b),"The given range should not contain any link.");var d=h,e=m.createElementNS(odf.Namespaces.textns,"text:a");e.setAttributeNS(odf.Namespaces.xlinkns,"xlink:type","simple");e.setAttributeNS(odf.Namespaces.xlinkns,"xlink:href",d);b.parentNode.insertBefore(e,b);e.appendChild(b);-1===a.indexOf(c)&&a.push(c)});c.forEach(n.normalizeTextNodes);f.detach();r.getOdfCanvas().refreshSize();r.getOdfCanvas().rerenderAnnotations();a.forEach(function(a){r.emit(ops.OdtDocument.signalParagraphChanged,{paragraphElement:a,
memberId:k,timeStamp:b})});return!0};this.spec=function(){return{optype:"ApplyHyperlink",memberid:k,timestamp:b,position:p,length:d,hyperlink:h}}};
// Input 52
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpInsertImage=function(){var g,k,b,p,d,h,n,q,r=odf.Namespaces.drawns,m=odf.Namespaces.svgns,f=odf.Namespaces.textns,c=odf.Namespaces.xlinkns;this.init=function(a){g=a.memberid;k=a.timestamp;b=a.position;p=a.filename;d=a.frameWidth;h=a.frameHeight;n=a.frameStyleName;q=a.frameName};this.isEdit=!0;this.group=void 0;this.execute=function(a){var e=a.getOdfCanvas(),l=a.getTextNodeAtStep(b,g),s,t;if(!l)return!1;s=l.textNode;t=a.getParagraphElement(s);var l=l.offset!==s.length?s.splitText(l.offset):s.nextSibling,
y=a.getDOMDocument(),B=y.createElementNS(r,"draw:image"),y=y.createElementNS(r,"draw:frame");B.setAttributeNS(c,"xlink:href",p);B.setAttributeNS(c,"xlink:type","simple");B.setAttributeNS(c,"xlink:show","embed");B.setAttributeNS(c,"xlink:actuate","onLoad");y.setAttributeNS(r,"draw:style-name",n);y.setAttributeNS(r,"draw:name",q);y.setAttributeNS(f,"text:anchor-type","as-char");y.setAttributeNS(m,"svg:width",d);y.setAttributeNS(m,"svg:height",h);y.appendChild(B);s.parentNode.insertBefore(y,l);a.emit(ops.OdtDocument.signalStepsInserted,
{position:b,length:1});0===s.length&&s.parentNode.removeChild(s);e.addCssForFrameWithImage(y);e.refreshCSS();a.emit(ops.OdtDocument.signalParagraphChanged,{paragraphElement:t,memberId:g,timeStamp:k});e.rerenderAnnotations();return!0};this.spec=function(){return{optype:"InsertImage",memberid:g,timestamp:k,filename:p,position:b,frameWidth:d,frameHeight:h,frameStyleName:n,frameName:q}}};
// Input 53
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpInsertTable=function(){function g(b,c){var a;if(1===m.length)a=m[0];else if(3===m.length)switch(b){case 0:a=m[0];break;case p-1:a=m[2];break;default:a=m[1]}else a=m[b];if(1===a.length)return a[0];if(3===a.length)switch(c){case 0:return a[0];case d-1:return a[2];default:return a[1]}return a[c]}var k,b,p,d,h,n,q,r,m;this.init=function(f){k=f.memberid;b=f.timestamp;h=f.position;p=f.initialRows;d=f.initialColumns;n=f.tableName;q=f.tableStyleName;r=f.tableColumnStyleName;m=f.tableCellStyleMatrix};
this.isEdit=!0;this.group=void 0;this.execute=function(f){var c=f.getTextNodeAtStep(h),a=f.getRootNode();if(c){var e=f.getDOMDocument(),l=e.createElementNS("urn:oasis:names:tc:opendocument:xmlns:table:1.0","table:table"),m=e.createElementNS("urn:oasis:names:tc:opendocument:xmlns:table:1.0","table:table-column"),t,y,B,D;q&&l.setAttributeNS("urn:oasis:names:tc:opendocument:xmlns:table:1.0","table:style-name",q);n&&l.setAttributeNS("urn:oasis:names:tc:opendocument:xmlns:table:1.0","table:name",n);m.setAttributeNS("urn:oasis:names:tc:opendocument:xmlns:table:1.0",
"table:number-columns-repeated",d);r&&m.setAttributeNS("urn:oasis:names:tc:opendocument:xmlns:table:1.0","table:style-name",r);l.appendChild(m);for(B=0;B<p;B+=1){m=e.createElementNS("urn:oasis:names:tc:opendocument:xmlns:table:1.0","table:table-row");for(D=0;D<d;D+=1)t=e.createElementNS("urn:oasis:names:tc:opendocument:xmlns:table:1.0","table:table-cell"),(y=g(B,D))&&t.setAttributeNS("urn:oasis:names:tc:opendocument:xmlns:table:1.0","table:style-name",y),y=e.createElementNS("urn:oasis:names:tc:opendocument:xmlns:text:1.0",
"text:p"),t.appendChild(y),m.appendChild(t);l.appendChild(m)}c=f.getParagraphElement(c.textNode);a.insertBefore(l,c.nextSibling);f.emit(ops.OdtDocument.signalStepsInserted,{position:h,length:d*p+1});f.getOdfCanvas().refreshSize();f.emit(ops.OdtDocument.signalTableAdded,{tableElement:l,memberId:k,timeStamp:b});f.getOdfCanvas().rerenderAnnotations();return!0}return!1};this.spec=function(){return{optype:"InsertTable",memberid:k,timestamp:b,position:h,initialRows:p,initialColumns:d,tableName:n,tableStyleName:q,
tableColumnStyleName:r,tableCellStyleMatrix:m}}};
// Input 54
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpInsertText=function(){var g,k,b,p,d;this.init=function(h){g=h.memberid;k=h.timestamp;b=h.position;d=h.text;p="true"===h.moveCursor||!0===h.moveCursor};this.isEdit=!0;this.group=void 0;this.execute=function(h){var n,q,r,m=null,f=h.getDOMDocument(),c,a=0,e,l=h.getCursor(g),s;h.upgradeWhitespacesAtPosition(b);if(n=h.getTextNodeAtStep(b)){q=n.textNode;m=q.nextSibling;r=q.parentNode;c=h.getParagraphElement(q);for(s=0;s<d.length;s+=1)if(" "===d[s]&&(0===s||s===d.length-1||" "===d[s-1])||"\t"===d[s])0===
a?(n.offset!==q.length&&(m=q.splitText(n.offset)),0<s&&q.appendData(d.substring(0,s))):a<s&&(a=d.substring(a,s),r.insertBefore(f.createTextNode(a),m)),a=s+1,e=" "===d[s]?"text:s":"text:tab",e=f.createElementNS("urn:oasis:names:tc:opendocument:xmlns:text:1.0",e),e.appendChild(f.createTextNode(d[s])),r.insertBefore(e,m);0===a?q.insertData(n.offset,d):a<d.length&&(n=d.substring(a),r.insertBefore(f.createTextNode(n),m));r=q.parentNode;m=q.nextSibling;r.removeChild(q);r.insertBefore(q,m);0===q.length&&
q.parentNode.removeChild(q);h.emit(ops.OdtDocument.signalStepsInserted,{position:b,length:d.length});l&&p&&(h.moveCursor(g,b+d.length,0),h.emit(ops.Document.signalCursorMoved,l));0<b&&(1<b&&h.downgradeWhitespacesAtPosition(b-2),h.downgradeWhitespacesAtPosition(b-1));h.downgradeWhitespacesAtPosition(b);h.downgradeWhitespacesAtPosition(b+d.length-1);h.downgradeWhitespacesAtPosition(b+d.length);h.getOdfCanvas().refreshSize();h.emit(ops.OdtDocument.signalParagraphChanged,{paragraphElement:c,memberId:g,
timeStamp:k});h.getOdfCanvas().rerenderAnnotations();return!0}return!1};this.spec=function(){return{optype:"InsertText",memberid:g,timestamp:k,position:b,text:d,moveCursor:p}}};
// Input 55
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpMoveCursor=function(){var g,k,b,p,d;this.init=function(h){g=h.memberid;k=h.timestamp;b=h.position;p=h.length||0;d=h.selectionType||ops.OdtCursor.RangeSelection};this.isEdit=!1;this.group=void 0;this.execute=function(h){var k=h.getCursor(g),q;if(!k)return!1;q=h.convertCursorToDomRange(b,p);k.setSelectedRange(q,0<=p);k.setSelectionType(d);h.emit(ops.Document.signalCursorMoved,k);return!0};this.spec=function(){return{optype:"MoveCursor",memberid:g,timestamp:k,position:b,length:p,selectionType:d}}};
// Input 56
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpRemoveAnnotation=function(){var g,k,b,p,d;this.init=function(h){g=h.memberid;k=h.timestamp;b=parseInt(h.position,10);p=parseInt(h.length,10);d=new core.DomUtils};this.isEdit=!0;this.group=void 0;this.execute=function(h){function g(b){r.parentNode.insertBefore(b,r)}for(var k=h.getIteratorAtPosition(b).container(),r;k.namespaceURI!==odf.Namespaces.officens||"annotation"!==k.localName;)k=k.parentNode;if(null===k)return!1;r=k;k=r.annotationEndElement;h.getOdfCanvas().forgetAnnotations();d.getElementsByTagNameNS(r,
"urn:webodf:names:cursor","cursor").forEach(g);d.getElementsByTagNameNS(r,"urn:webodf:names:cursor","anchor").forEach(g);r.parentNode.removeChild(r);k&&k.parentNode.removeChild(k);h.emit(ops.OdtDocument.signalStepsRemoved,{position:0<b?b-1:b,length:p});h.fixCursorPositions();h.getOdfCanvas().refreshAnnotations();return!0};this.spec=function(){return{optype:"RemoveAnnotation",memberid:g,timestamp:k,position:b,length:p}}};
// Input 57
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpRemoveBlob=function(){var g,k,b;this.init=function(p){g=p.memberid;k=p.timestamp;b=p.filename};this.isEdit=!0;this.group=void 0;this.execute=function(g){g.getOdfCanvas().odfContainer().removeBlob(b);return!0};this.spec=function(){return{optype:"RemoveBlob",memberid:g,timestamp:k,filename:b}}};
// Input 58
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpRemoveCursor=function(){var g,k;this.init=function(b){g=b.memberid;k=b.timestamp};this.isEdit=!1;this.group=void 0;this.execute=function(b){return b.removeCursor(g)?!0:!1};this.spec=function(){return{optype:"RemoveCursor",memberid:g,timestamp:k}}};
// Input 59
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpRemoveHyperlink=function(){var g,k,b,p,d=new core.DomUtils,h=new odf.OdfUtils;this.init=function(d){g=d.memberid;k=d.timestamp;b=d.position;p=d.length};this.isEdit=!0;this.group=void 0;this.execute=function(n){var q=n.convertCursorToDomRange(b,p),r=h.getHyperlinkElements(q);runtime.assert(1===r.length,"The given range should only contain a single link.");r=d.mergeIntoParent(r[0]);q.detach();n.getOdfCanvas().refreshSize();n.emit(ops.OdtDocument.signalParagraphChanged,{paragraphElement:h.getParagraphElement(r),
memberId:g,timeStamp:k});n.getOdfCanvas().rerenderAnnotations();return!0};this.spec=function(){return{optype:"RemoveHyperlink",memberid:g,timestamp:k,position:b,length:p}}};
// Input 60
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpRemoveMember=function(){var g,k;this.init=function(b){g=b.memberid;k=parseInt(b.timestamp,10)};this.isEdit=!1;this.group=void 0;this.execute=function(b){if(!b.getMember(g))return!1;b.removeMember(g);b.emit(ops.Document.signalMemberRemoved,g);return!0};this.spec=function(){return{optype:"RemoveMember",memberid:g,timestamp:k}}};
// Input 61
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpRemoveStyle=function(){var g,k,b,p;this.init=function(d){g=d.memberid;k=d.timestamp;b=d.styleName;p=d.styleFamily};this.isEdit=!0;this.group=void 0;this.execute=function(d){var h=d.getStyleElement(b,p);if(!h)return!1;h.parentNode.removeChild(h);d.getOdfCanvas().refreshCSS();d.emit(ops.OdtDocument.signalCommonStyleDeleted,{name:b,family:p});return!0};this.spec=function(){return{optype:"RemoveStyle",memberid:g,timestamp:k,styleName:b,styleFamily:p}}};
// Input 62
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpRemoveText=function(){function g(b){function d(a){return q.hasOwnProperty(a.namespaceURI)||"br"===a.localName&&h.isLineBreak(a.parentNode)||a.nodeType===Node.TEXT_NODE&&q.hasOwnProperty(a.parentNode.namespaceURI)}function f(a){if(h.isCharacterElement(a))return!1;if(a.nodeType===Node.TEXT_NODE)return 0===a.textContent.length;for(a=a.firstChild;a;){if(q.hasOwnProperty(a.namespaceURI)||!f(a))return!1;a=a.nextSibling}return!0}function c(a){var e;a.nodeType===Node.TEXT_NODE?(e=a.parentNode,e.removeChild(a)):
e=n.removeUnwantedNodes(a,d);return e&&!h.isParagraph(e)&&e!==b&&f(e)?c(e):e}this.isEmpty=f;this.mergeChildrenIntoParent=c}var k,b,p,d,h,n,q={};this.init=function(g){runtime.assert(0<=g.length,"OpRemoveText only supports positive lengths");k=g.memberid;b=g.timestamp;p=parseInt(g.position,10);d=parseInt(g.length,10);h=new odf.OdfUtils;n=new core.DomUtils;q[odf.Namespaces.dbns]=!0;q[odf.Namespaces.dcns]=!0;q[odf.Namespaces.dr3dns]=!0;q[odf.Namespaces.drawns]=!0;q[odf.Namespaces.chartns]=!0;q[odf.Namespaces.formns]=
!0;q[odf.Namespaces.numberns]=!0;q[odf.Namespaces.officens]=!0;q[odf.Namespaces.presentationns]=!0;q[odf.Namespaces.stylens]=!0;q[odf.Namespaces.svgns]=!0;q[odf.Namespaces.tablens]=!0;q[odf.Namespaces.textns]=!0};this.isEdit=!0;this.group=void 0;this.execute=function(q){var m,f,c,a,e=q.getCursor(k),l=new g(q.getRootNode());q.upgradeWhitespacesAtPosition(p);q.upgradeWhitespacesAtPosition(p+d);f=q.convertCursorToDomRange(p,d);n.splitBoundaries(f);m=q.getParagraphElement(f.startContainer);c=h.getTextElements(f,
!1,!0);a=h.getParagraphElements(f);f.detach();c.forEach(function(a){l.mergeChildrenIntoParent(a)});f=a.reduce(function(a,b){var c,d=a,e=b,f,h=null;l.isEmpty(a)&&(b.parentNode!==a.parentNode&&(f=b.parentNode,a.parentNode.insertBefore(b,a.nextSibling)),e=a,d=b,h=d.getElementsByTagNameNS("urn:webodf:names:editinfo","editinfo").item(0)||d.firstChild);for(;e.firstChild;)c=e.firstChild,e.removeChild(c),"editinfo"!==c.localName&&d.insertBefore(c,h);f&&l.isEmpty(f)&&l.mergeChildrenIntoParent(f);l.mergeChildrenIntoParent(e);
return d});q.emit(ops.OdtDocument.signalStepsRemoved,{position:p,length:d});q.downgradeWhitespacesAtPosition(p);q.fixCursorPositions();q.getOdfCanvas().refreshSize();q.emit(ops.OdtDocument.signalParagraphChanged,{paragraphElement:f||m,memberId:k,timeStamp:b});e&&(e.resetSelectionType(),q.emit(ops.Document.signalCursorMoved,e));q.getOdfCanvas().rerenderAnnotations();return!0};this.spec=function(){return{optype:"RemoveText",memberid:k,timestamp:b,position:p,length:d}}};
// Input 63
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpSetBlob=function(){var g,k,b,p,d;this.init=function(h){g=h.memberid;k=h.timestamp;b=h.filename;p=h.mimetype;d=h.content};this.isEdit=!0;this.group=void 0;this.execute=function(h){h.getOdfCanvas().odfContainer().setBlob(b,p,d);return!0};this.spec=function(){return{optype:"SetBlob",memberid:g,timestamp:k,filename:b,mimetype:p,content:d}}};
// Input 64
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpSetParagraphStyle=function(){var g,k,b,p;this.init=function(d){g=d.memberid;k=d.timestamp;b=d.position;p=d.styleName};this.isEdit=!0;this.group=void 0;this.execute=function(d){var h;h=d.getIteratorAtPosition(b);return(h=d.getParagraphElement(h.container()))?(""!==p?h.setAttributeNS("urn:oasis:names:tc:opendocument:xmlns:text:1.0","text:style-name",p):h.removeAttributeNS("urn:oasis:names:tc:opendocument:xmlns:text:1.0","style-name"),d.getOdfCanvas().refreshSize(),d.emit(ops.OdtDocument.signalParagraphChanged,
{paragraphElement:h,timeStamp:k,memberId:g}),d.getOdfCanvas().rerenderAnnotations(),!0):!1};this.spec=function(){return{optype:"SetParagraphStyle",memberid:g,timestamp:k,position:b,styleName:p}}};
// Input 65
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpSplitParagraph=function(){var g,k,b,p,d;this.init=function(h){g=h.memberid;k=h.timestamp;b=h.position;p="true"===h.moveCursor||!0===h.moveCursor;d=new odf.OdfUtils};this.isEdit=!0;this.group=void 0;this.execute=function(h){var n,q,r,m,f,c,a,e=h.getCursor(g);h.upgradeWhitespacesAtPosition(b);n=h.getTextNodeAtStep(b);if(!n)return!1;q=h.getParagraphElement(n.textNode);if(!q)return!1;r=d.isListItem(q.parentNode)?q.parentNode:q;0===n.offset?(a=n.textNode.previousSibling,c=null):(a=n.textNode,c=n.offset>=
n.textNode.length?null:n.textNode.splitText(n.offset));for(m=n.textNode;m!==r;){m=m.parentNode;f=m.cloneNode(!1);c&&f.appendChild(c);if(a)for(;a&&a.nextSibling;)f.appendChild(a.nextSibling);else for(;m.firstChild;)f.appendChild(m.firstChild);m.parentNode.insertBefore(f,m.nextSibling);a=m;c=f}d.isListItem(c)&&(c=c.childNodes.item(0));0===n.textNode.length&&n.textNode.parentNode.removeChild(n.textNode);h.emit(ops.OdtDocument.signalStepsInserted,{position:b,length:1});e&&p&&(h.moveCursor(g,b+1,0),h.emit(ops.Document.signalCursorMoved,
e));h.fixCursorPositions();h.getOdfCanvas().refreshSize();h.emit(ops.OdtDocument.signalParagraphChanged,{paragraphElement:q,memberId:g,timeStamp:k});h.emit(ops.OdtDocument.signalParagraphChanged,{paragraphElement:c,memberId:g,timeStamp:k});h.getOdfCanvas().rerenderAnnotations();return!0};this.spec=function(){return{optype:"SplitParagraph",memberid:g,timestamp:k,position:b,moveCursor:p}}};
// Input 66
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpUpdateMember=function(){function g(b){var d="//dc:creator[@editinfo:memberid='"+k+"']";b=xmldom.XPath.getODFElementsWithXPath(b.getRootNode(),d,function(b){return"editinfo"===b?"urn:webodf:names:editinfo":odf.Namespaces.lookupNamespaceURI(b)});for(d=0;d<b.length;d+=1)b[d].textContent=p.fullName}var k,b,p,d;this.init=function(h){k=h.memberid;b=parseInt(h.timestamp,10);p=h.setProperties;d=h.removedProperties};this.isEdit=!1;this.group=void 0;this.execute=function(b){var n=b.getMember(k);if(!n)return!1;
d&&n.removeProperties(d);p&&(n.setProperties(p),p.fullName&&g(b));b.emit(ops.Document.signalMemberUpdated,n);return!0};this.spec=function(){return{optype:"UpdateMember",memberid:k,timestamp:b,setProperties:p,removedProperties:d}}};
// Input 67
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpUpdateMetadata=function(){var g,k,b,p;this.init=function(d){g=d.memberid;k=parseInt(d.timestamp,10);b=d.setProperties;p=d.removedProperties};this.isEdit=!0;this.group=void 0;this.execute=function(d){d=d.getOdfCanvas().odfContainer();var h=[];p&&(h=p.attributes.split(","));d.setMetadata(b,h);return!0};this.spec=function(){return{optype:"UpdateMetadata",memberid:g,timestamp:k,setProperties:b,removedProperties:p}}};
// Input 68
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OpUpdateParagraphStyle=function(){function g(b,d){var h,f,c=d?d.split(","):[];for(h=0;h<c.length;h+=1)f=c[h].split(":"),b.removeAttributeNS(odf.Namespaces.lookupNamespaceURI(f[0]),f[1])}var k,b,p,d,h,n=odf.Namespaces.stylens;this.init=function(g){k=g.memberid;b=g.timestamp;p=g.styleName;d=g.setProperties;h=g.removedProperties};this.isEdit=!0;this.group=void 0;this.execute=function(b){var k=b.getFormatting(),m,f,c;return(m=""!==p?b.getParagraphStyleElement(p):k.getDefaultStyleElement("paragraph"))?
(f=m.getElementsByTagNameNS(n,"paragraph-properties").item(0),c=m.getElementsByTagNameNS(n,"text-properties").item(0),d&&k.updateStyle(m,d),h&&(k=h["style:paragraph-properties"],f&&k&&(g(f,k.attributes),0===f.attributes.length&&m.removeChild(f)),k=h["style:text-properties"],c&&k&&(g(c,k.attributes),0===c.attributes.length&&m.removeChild(c)),g(m,h.attributes)),b.getOdfCanvas().refreshCSS(),b.emit(ops.OdtDocument.signalParagraphStyleModified,p),b.getOdfCanvas().rerenderAnnotations(),!0):!1};this.spec=
function(){return{optype:"UpdateParagraphStyle",memberid:k,timestamp:b,styleName:p,setProperties:d,removedProperties:h}}};
// Input 69
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OperationFactory=function(){var g;this.register=function(k,b){g[k]=b};this.create=function(k){var b=null,p=g[k.optype];p&&(b=new p,b.init(k));return b};g={AddMember:ops.OpAddMember,UpdateMember:ops.OpUpdateMember,RemoveMember:ops.OpRemoveMember,AddCursor:ops.OpAddCursor,ApplyDirectStyling:ops.OpApplyDirectStyling,SetBlob:ops.OpSetBlob,RemoveBlob:ops.OpRemoveBlob,InsertImage:ops.OpInsertImage,InsertTable:ops.OpInsertTable,InsertText:ops.OpInsertText,RemoveText:ops.OpRemoveText,SplitParagraph:ops.OpSplitParagraph,
SetParagraphStyle:ops.OpSetParagraphStyle,UpdateParagraphStyle:ops.OpUpdateParagraphStyle,AddStyle:ops.OpAddStyle,RemoveStyle:ops.OpRemoveStyle,MoveCursor:ops.OpMoveCursor,RemoveCursor:ops.OpRemoveCursor,AddAnnotation:ops.OpAddAnnotation,RemoveAnnotation:ops.OpRemoveAnnotation,UpdateMetadata:ops.OpUpdateMetadata,ApplyHyperlink:ops.OpApplyHyperlink,RemoveHyperlink:ops.OpRemoveHyperlink}};
// Input 70
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OperationRouter=function(){};ops.OperationRouter.prototype.setOperationFactory=function(g){};ops.OperationRouter.prototype.setPlaybackFunction=function(g){};ops.OperationRouter.prototype.push=function(g){};ops.OperationRouter.prototype.close=function(g){};ops.OperationRouter.prototype.subscribe=function(g,k){};ops.OperationRouter.prototype.unsubscribe=function(g,k){};ops.OperationRouter.prototype.hasLocalUnsyncedOps=function(){};ops.OperationRouter.prototype.hasSessionHostConnection=function(){};
ops.OperationRouter.signalProcessingBatchStart="router/batchstart";ops.OperationRouter.signalProcessingBatchEnd="router/batchend";
// Input 71
/*

 Copyright (C) 2012 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.TrivialOperationRouter=function(){var g=new core.EventNotifier([ops.OperationRouter.signalProcessingBatchStart,ops.OperationRouter.signalProcessingBatchEnd]),k,b,p=0;this.setOperationFactory=function(b){k=b};this.setPlaybackFunction=function(d){b=d};this.push=function(d){p+=1;g.emit(ops.OperationRouter.signalProcessingBatchStart,{});d.forEach(function(d){d=d.spec();d.timestamp=(new Date).getTime();d=k.create(d);d.group="g"+p;b(d)});g.emit(ops.OperationRouter.signalProcessingBatchEnd,{})};this.close=
function(b){b()};this.subscribe=function(b,h){g.subscribe(b,h)};this.unsubscribe=function(b,h){g.unsubscribe(b,h)};this.hasLocalUnsyncedOps=function(){return!1};this.hasSessionHostConnection=function(){return!0}};
// Input 72
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.Session=function(g){function k(b){d.emit(ops.OdtDocument.signalProcessingBatchStart,b)}function b(b){d.emit(ops.OdtDocument.signalProcessingBatchEnd,b)}var p=new ops.OperationFactory,d=new ops.OdtDocument(g),h=null;this.setOperationFactory=function(b){p=b;h&&h.setOperationFactory(p)};this.setOperationRouter=function(g){h&&(h.unsubscribe(ops.OperationRouter.signalProcessingBatchStart,k),h.unsubscribe(ops.OperationRouter.signalProcessingBatchEnd,b));h=g;h.subscribe(ops.OperationRouter.signalProcessingBatchStart,
k);h.subscribe(ops.OperationRouter.signalProcessingBatchEnd,b);g.setPlaybackFunction(function(b){d.emit(ops.OdtDocument.signalOperationStart,b);return b.execute(d)?(d.emit(ops.OdtDocument.signalOperationEnd,b),!0):!1});g.setOperationFactory(p)};this.getOperationFactory=function(){return p};this.getOdtDocument=function(){return d};this.enqueue=function(b){h.push(b)};this.close=function(b){h.close(function(h){h?b(h):d.close(b)})};this.destroy=function(b){d.destroy(b)};this.setOperationRouter(new ops.TrivialOperationRouter)};
// Input 73
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.AnnotationController=function(g,k){function b(){var b=n.getCursor(k),b=b&&b.getNode(),c=!1;if(b){a:{for(c=n.getRootNode();b&&b!==c;){if(b.namespaceURI===m&&"annotation"===b.localName){b=!0;break a}b=b.parentNode}b=!1}c=!b}c!==q&&(q=c,r.emit(gui.AnnotationController.annotatableChanged,q))}function p(d){d.getMemberId()===k&&b()}function d(d){d===k&&b()}function h(d){d.getMemberId()===k&&b()}var n=g.getOdtDocument(),q=!1,r=new core.EventNotifier([gui.AnnotationController.annotatableChanged]),m=odf.Namespaces.officens;
this.isAnnotatable=function(){return q};this.addAnnotation=function(){var b=new ops.OpAddAnnotation,c=n.getCursorSelection(k),a=c.length,c=c.position;q&&(c=0<=a?c:c+a,a=Math.abs(a),b.init({memberid:k,position:c,length:a,name:k+Date.now()}),g.enqueue([b]))};this.removeAnnotation=function(b){var c,a;c=n.convertDomPointToCursorStep(b,0)+1;a=n.convertDomPointToCursorStep(b,b.childNodes.length);b=new ops.OpRemoveAnnotation;b.init({memberid:k,position:c,length:a-c});a=new ops.OpMoveCursor;a.init({memberid:k,
position:0<c?c-1:c,length:0});g.enqueue([b,a])};this.subscribe=function(b,c){r.subscribe(b,c)};this.unsubscribe=function(b,c){r.unsubscribe(b,c)};this.destroy=function(b){n.unsubscribe(ops.Document.signalCursorAdded,p);n.unsubscribe(ops.Document.signalCursorRemoved,d);n.unsubscribe(ops.Document.signalCursorMoved,h);b()};n.subscribe(ops.Document.signalCursorAdded,p);n.subscribe(ops.Document.signalCursorRemoved,d);n.subscribe(ops.Document.signalCursorMoved,h);b()};
gui.AnnotationController.annotatableChanged="annotatable/changed";(function(){return gui.AnnotationController})();
// Input 74
gui.Avatar=function(g,k){var b=this,p,d,h;this.setColor=function(b){d.style.borderColor=b};this.setImageUrl=function(g){b.isVisible()?d.src=g:h=g};this.isVisible=function(){return"block"===p.style.display};this.show=function(){h&&(d.src=h,h=void 0);p.style.display="block"};this.hide=function(){p.style.display="none"};this.markAsFocussed=function(b){b?p.classList.add("active"):p.classList.remove("active")};this.destroy=function(b){g.removeChild(p);b()};(function(){var b=g.ownerDocument,h=b.documentElement.namespaceURI;
p=b.createElementNS(h,"div");d=b.createElementNS(h,"img");d.width=64;d.height=64;p.appendChild(d);p.style.width="64px";p.style.height="70px";p.style.position="absolute";p.style.top="-80px";p.style.left="-34px";p.style.display=k?"block":"none";p.className="handle";g.appendChild(p)})()};
// Input 75
gui.Caret=function(g,k,b){function p(){r.style.opacity="0"===r.style.opacity?"1":"0";s.trigger()}function d(a,b){var c=a.getBoundingClientRect(),d=0,e=0;c&&b&&(d=Math.max(c.top,b.top),e=Math.min(c.bottom,b.bottom));return e-d}function h(){Object.keys(D).forEach(function(a){v[a]=D[a]})}function n(){var e,f,l,k;if(!1===D.isShown||g.getSelectionType()!==ops.OdtCursor.RangeSelection||!b&&!g.getSelectedRange().collapsed)D.visibility="hidden",r.style.visibility="hidden",s.cancel();else{D.visibility="visible";
r.style.visibility="visible";if(!1===D.isFocused)r.style.opacity="1",s.cancel();else{if(t||v.visibility!==D.visibility)r.style.opacity="1",s.cancel();s.trigger()}if(B||y||v.visibility!==D.visibility){e=g.getSelectedRange().cloneRange();f=g.getNode();var n=null;f.previousSibling&&(l=f.previousSibling.nodeType===Node.TEXT_NODE?f.previousSibling.textContent.length:f.previousSibling.childNodes.length,e.setStart(f.previousSibling,0<l?l-1:0),e.setEnd(f.previousSibling,l),(l=e.getBoundingClientRect())&&
l.height&&(n=l));f.nextSibling&&(e.setStart(f.nextSibling,0),e.setEnd(f.nextSibling,0<(f.nextSibling.nodeType===Node.TEXT_NODE?f.nextSibling.textContent.length:f.nextSibling.childNodes.length)?1:0),(l=e.getBoundingClientRect())&&l.height&&(!n||d(f,l)>d(f,n))&&(n=l));f=n;n=g.getDocument().getCanvas();e=n.getZoomLevel();n=a.getBoundingClientRect(n.getSizer());f?(r.style.top="0",l=a.getBoundingClientRect(r),8>f.height&&(f={top:f.top-(8-f.height)/2,height:8}),r.style.height=a.adaptRangeDifferenceToZoomLevel(f.height,
e)+"px",r.style.top=a.adaptRangeDifferenceToZoomLevel(f.top-l.top,e)+"px"):(r.style.height="1em",r.style.top="5%");c&&(f=runtime.getWindow().getComputedStyle(r,null),l=a.getBoundingClientRect(r),c.style.bottom=a.adaptRangeDifferenceToZoomLevel(n.bottom-l.bottom,e)+"px",c.style.left=a.adaptRangeDifferenceToZoomLevel(l.right-n.left,e)+"px",f.font?c.style.font=f.font:(c.style.fontStyle=f.fontStyle,c.style.fontVariant=f.fontVariant,c.style.fontWeight=f.fontWeight,c.style.fontSize=f.fontSize,c.style.lineHeight=
f.lineHeight,c.style.fontFamily=f.fontFamily))}if(y){var n=g.getDocument().getCanvas().getElement().parentNode,p;l=n.offsetWidth-n.clientWidth+5;k=n.offsetHeight-n.clientHeight+5;p=r.getBoundingClientRect();e=p.left-l;f=p.top-k;l=p.right+l;k=p.bottom+k;p=n.getBoundingClientRect();f<p.top?n.scrollTop-=p.top-f:k>p.bottom&&(n.scrollTop+=k-p.bottom);e<p.left?n.scrollLeft-=p.left-e:l>p.right&&(n.scrollLeft+=l-p.right)}}v.isFocused!==D.isFocused&&m.markAsFocussed(D.isFocused);h();B=y=t=!1}function q(a){f.removeChild(r);
a()}var r,m,f,c,a=new core.DomUtils,e=new core.Async,l,s,t=!1,y=!1,B=!1,D={isFocused:!1,isShown:!0,visibility:"hidden"},v={isFocused:!D.isFocused,isShown:!D.isShown,visibility:"hidden"};this.handleUpdate=function(){B=!0;"hidden"!==D.visibility&&(D.visibility="hidden",r.style.visibility="hidden");l.trigger()};this.refreshCursorBlinking=function(){t=!0;l.trigger()};this.setFocus=function(){D.isFocused=!0;l.trigger()};this.removeFocus=function(){D.isFocused=!1;l.trigger()};this.show=function(){D.isShown=
!0;l.trigger()};this.hide=function(){D.isShown=!1;l.trigger()};this.setAvatarImageUrl=function(a){m.setImageUrl(a)};this.setColor=function(a){r.style.borderColor=a;m.setColor(a)};this.getCursor=function(){return g};this.getFocusElement=function(){return r};this.toggleHandleVisibility=function(){m.isVisible()?m.hide():m.show()};this.showHandle=function(){m.show()};this.hideHandle=function(){m.hide()};this.setOverlayElement=function(a){c=a;B=!0;l.trigger()};this.ensureVisible=function(){y=!0;l.trigger()};
this.destroy=function(a){e.destroyAll([l.destroy,s.destroy,m.destroy,q],a)};(function(){var a=g.getDocument().getDOMDocument();r=a.createElementNS(a.documentElement.namespaceURI,"span");r.className="caret";r.style.top="5%";f=g.getNode();f.appendChild(r);m=new gui.Avatar(f,k);l=new core.ScheduledTask(n,0);s=new core.ScheduledTask(p,500);l.triggerImmediate()})()};
// Input 76
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.TextSerializer=function(){function g(p){var d="",h=k.filter?k.filter.acceptNode(p):NodeFilter.FILTER_ACCEPT,n=p.nodeType,q;if((h===NodeFilter.FILTER_ACCEPT||h===NodeFilter.FILTER_SKIP)&&b.isTextContentContainingNode(p))for(q=p.firstChild;q;)d+=g(q),q=q.nextSibling;h===NodeFilter.FILTER_ACCEPT&&(n===Node.ELEMENT_NODE&&b.isParagraph(p)?d+="\n":n===Node.TEXT_NODE&&p.textContent&&(d+=p.textContent));return d}var k=this,b=new odf.OdfUtils;this.filter=null;this.writeToString=function(b){if(!b)return"";
b=g(b);"\n"===b[b.length-1]&&(b=b.substr(0,b.length-1));return b}};
// Input 77
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.MimeDataExporter=function(){var g,k;this.exportRangeToDataTransfer=function(b,k){var d=!0,h;h=k.startContainer.ownerDocument.createElement("span");h.appendChild(k.cloneContents());h=b.setData("text/plain",g.writeToString(h));return d&&h};g=new odf.TextSerializer;k=new odf.OdfNodeFilter;g.filter=k};
// Input 78
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.Clipboard=function(g){this.setDataFromRange=function(k,b){var p;p=k.clipboardData;var d=runtime.getWindow();!p&&d&&(p=d.clipboardData);p?(p=g.exportRangeToDataTransfer(p,b),k.preventDefault()):p=!1;return p}};
// Input 79
/*

 Copyright (C) 2012-2014 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.StyleSummary=function(g){function k(b,k){var p=b+"|"+k,r;d.hasOwnProperty(p)||(r=[],g.forEach(function(d){d=(d=d[b])&&d[k];-1===r.indexOf(d)&&r.push(d)}),d[p]=r);return d[p]}function b(b,d,g){return function(){var p=k(b,d);return g.length>=p.length&&p.every(function(b){return-1!==g.indexOf(b)})}}function p(b,d){var g=k(b,d);return 1===g.length?g[0]:void 0}var d={};this.getPropertyValues=k;this.getCommonValue=p;this.isBold=b("style:text-properties","fo:font-weight",["bold"]);this.isItalic=b("style:text-properties",
"fo:font-style",["italic"]);this.hasUnderline=b("style:text-properties","style:text-underline-style",["solid"]);this.hasStrikeThrough=b("style:text-properties","style:text-line-through-style",["solid"]);this.fontSize=function(){var b=p("style:text-properties","fo:font-size");return b&&parseFloat(b)};this.fontName=function(){return p("style:text-properties","style:font-name")};this.isAlignedLeft=b("style:paragraph-properties","fo:text-align",["left","start"]);this.isAlignedCenter=b("style:paragraph-properties",
"fo:text-align",["center"]);this.isAlignedRight=b("style:paragraph-properties","fo:text-align",["right","end"]);this.isAlignedJustified=b("style:paragraph-properties","fo:text-align",["justify"]);this.text={isBold:this.isBold,isItalic:this.isItalic,hasUnderline:this.hasUnderline,hasStrikeThrough:this.hasStrikeThrough,fontSize:this.fontSize,fontName:this.fontName};this.paragraph={isAlignedLeft:this.isAlignedLeft,isAlignedCenter:this.isAlignedCenter,isAlignedRight:this.isAlignedRight,isAlignedJustified:this.isAlignedJustified}};
// Input 80
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.DirectFormattingController=function(g,k,b,p){function d(a){var b;a.collapsed?(b=a.startContainer,b.hasChildNodes()&&a.startOffset<b.childNodes.length&&(b=b.childNodes.item(a.startOffset)),a=[b]):a=F.getTextNodes(a,!0);return a}function h(a,b){var c={};Object.keys(a).forEach(function(d){var e=a[d](),f=b[d]();e!==f&&(c[d]=f)});return c}function n(){var a,b,c;a=(a=(a=H.getCursor(k))&&a.getSelectedRange())?d(a):[];a=H.getFormatting().getAppliedStyles(a);a[0]&&G&&(a[0]=T.mergeObjects(a[0],G));R=a;
c=new gui.StyleSummary(R);a=h(z.text,c.text);b=h(z.paragraph,c.paragraph);z=c;0<Object.keys(a).length&&Z.emit(gui.DirectFormattingController.textStylingChanged,a);0<Object.keys(b).length&&Z.emit(gui.DirectFormattingController.paragraphStylingChanged,b)}function q(a){("string"===typeof a?a:a.getMemberId())===k&&n()}function r(){n()}function m(a){var b=H.getCursor(k);a=a.paragraphElement;b&&H.getParagraphElement(b.getNode())===a&&n()}function f(a,b){b(!a());return!0}function c(a){var b=H.getCursorSelection(k),
c={"style:text-properties":a};0!==b.length?(a=new ops.OpApplyDirectStyling,a.init({memberid:k,position:b.position,length:b.length,setProperties:c}),g.enqueue([a])):(G=T.mergeObjects(G||{},c),n())}function a(a,b){var d={};d[a]=b;c(d)}function e(a){a=a.spec();G&&a.memberid===k&&"SplitParagraph"!==a.optype&&(G=null,n())}function l(b){a("fo:font-weight",b?"bold":"normal")}function s(b){a("fo:font-style",b?"italic":"normal")}function t(b){a("style:text-underline-style",b?"solid":"none")}function y(b){a("style:text-line-through-style",
b?"solid":"none")}function B(a){return a===ops.StepsTranslator.NEXT_STEP}function D(a){var c=H.getCursor(k).getSelectedRange(),c=F.getParagraphElements(c),d=H.getFormatting(),e=[],f={},l;c.forEach(function(c){var h=H.convertDomPointToCursorStep(c,0,B),g=c.getAttributeNS(odf.Namespaces.textns,"style-name"),m;c=g?f.hasOwnProperty(g)?f[g]:void 0:l;c||(c=b.generateStyleName(),g?(f[g]=c,m=d.createDerivedStyleObject(g,"paragraph",{})):(l=c,m={}),m=a(m),g=new ops.OpAddStyle,g.init({memberid:k,styleName:c.toString(),
styleFamily:"paragraph",isAutomaticStyle:!0,setProperties:m}),e.push(g));g=new ops.OpSetParagraphStyle;g.init({memberid:k,styleName:c.toString(),position:h});e.push(g)});g.enqueue(e)}function v(a){D(function(b){return T.mergeObjects(b,a)})}function u(a){v({"style:paragraph-properties":{"fo:text-align":a}})}function w(a,b){var c=H.getFormatting().getDefaultTabStopDistance(),d=b["style:paragraph-properties"],e;d&&(d=d["fo:margin-left"])&&(e=F.parseLength(d));return T.mergeObjects(b,{"style:paragraph-properties":{"fo:margin-left":e&&
e.unit===c.unit?e.value+a*c.value+e.unit:a*c.value+c.unit}})}function x(a,b){var c=d(a),e=H.getFormatting().getAppliedStyles(c)[0],f=H.getFormatting().getAppliedStylesForElement(b);if(!e||"text"!==e["style:family"]||!e["style:text-properties"])return!1;if(!f||!f["style:text-properties"])return!0;e=e["style:text-properties"];f=f["style:text-properties"];return!Object.keys(e).every(function(a){return e[a]===f[a]})}function U(){}var E=this,H=g.getOdtDocument(),T=new core.Utils,F=new odf.OdfUtils,Z=new core.EventNotifier([gui.DirectFormattingController.textStylingChanged,
gui.DirectFormattingController.paragraphStylingChanged]),ba=odf.Namespaces.textns,N=core.PositionFilter.FilterResult.FILTER_ACCEPT,G,R=[],z=new gui.StyleSummary(R);this.formatTextSelection=c;this.createCursorStyleOp=function(a,b,c){var d=null;(c=c?R[0]:G)&&c["style:text-properties"]&&(d=new ops.OpApplyDirectStyling,d.init({memberid:k,position:a,length:b,setProperties:{"style:text-properties":c["style:text-properties"]}}),G=null,n());return d};this.setBold=l;this.setItalic=s;this.setHasUnderline=t;
this.setHasStrikethrough=y;this.setFontSize=function(b){a("fo:font-size",b+"pt")};this.setFontName=function(b){a("style:font-name",b)};this.getAppliedStyles=function(){return R};this.toggleBold=f.bind(E,function(){return z.isBold()},l);this.toggleItalic=f.bind(E,function(){return z.isItalic()},s);this.toggleUnderline=f.bind(E,function(){return z.hasUnderline()},t);this.toggleStrikethrough=f.bind(E,function(){return z.hasStrikeThrough()},y);this.isBold=function(){return z.isBold()};this.isItalic=function(){return z.isItalic()};
this.hasUnderline=function(){return z.hasUnderline()};this.hasStrikeThrough=function(){return z.hasStrikeThrough()};this.fontSize=function(){return z.fontSize()};this.fontName=function(){return z.fontName()};this.isAlignedLeft=function(){return z.isAlignedLeft()};this.isAlignedCenter=function(){return z.isAlignedCenter()};this.isAlignedRight=function(){return z.isAlignedRight()};this.isAlignedJustified=function(){return z.isAlignedJustified()};this.alignParagraphLeft=function(){u("left");return!0};
this.alignParagraphCenter=function(){u("center");return!0};this.alignParagraphRight=function(){u("right");return!0};this.alignParagraphJustified=function(){u("justify");return!0};this.indent=function(){D(w.bind(null,1));return!0};this.outdent=function(){D(w.bind(null,-1));return!0};this.createParagraphStyleOps=function(a){var c=H.getCursor(k),d=c.getSelectedRange(),e=[],f,l;c.hasForwardSelection()?(f=c.getAnchorNode(),l=c.getNode()):(f=c.getNode(),l=c.getAnchorNode());c=H.getParagraphElement(l);runtime.assert(Boolean(c),
"DirectFormattingController: Cursor outside paragraph");var g;a:{g=c;var h=gui.SelectionMover.createPositionIterator(g),m=new core.PositionFilterChain;m.addFilter(H.getPositionFilter());m.addFilter(H.createRootFilter(k));for(h.setUnfilteredPosition(d.endContainer,d.endOffset);h.nextPosition();)if(m.acceptPosition(h)===N){g=H.getParagraphElement(h.getCurrentNode())!==g;break a}g=!0}if(!g)return e;l!==f&&(c=H.getParagraphElement(f));if(!G&&!x(d,c))return e;d=R[0];if(!d)return e;if(f=c.getAttributeNS(ba,
"style-name"))d={"style:text-properties":d["style:text-properties"]},d=H.getFormatting().createDerivedStyleObject(f,"paragraph",d);c=b.generateStyleName();f=new ops.OpAddStyle;f.init({memberid:k,styleName:c,styleFamily:"paragraph",isAutomaticStyle:!0,setProperties:d});e.push(f);f=new ops.OpSetParagraphStyle;f.init({memberid:k,styleName:c,position:a});e.push(f);return e};this.subscribe=function(a,b){Z.subscribe(a,b)};this.unsubscribe=function(a,b){Z.unsubscribe(a,b)};this.destroy=function(a){H.unsubscribe(ops.Document.signalCursorAdded,
q);H.unsubscribe(ops.Document.signalCursorRemoved,q);H.unsubscribe(ops.Document.signalCursorMoved,q);H.unsubscribe(ops.OdtDocument.signalParagraphStyleModified,r);H.unsubscribe(ops.OdtDocument.signalParagraphChanged,m);H.unsubscribe(ops.OdtDocument.signalOperationEnd,e);a()};(function(){H.subscribe(ops.Document.signalCursorAdded,q);H.subscribe(ops.Document.signalCursorRemoved,q);H.subscribe(ops.Document.signalCursorMoved,q);H.subscribe(ops.OdtDocument.signalParagraphStyleModified,r);H.subscribe(ops.OdtDocument.signalParagraphChanged,
m);H.subscribe(ops.OdtDocument.signalOperationEnd,e);n();p||(E.alignParagraphCenter=U,E.alignParagraphJustified=U,E.alignParagraphLeft=U,E.alignParagraphRight=U,E.createParagraphStyleOps=function(){return[]},E.indent=U,E.outdent=U)})()};gui.DirectFormattingController.textStylingChanged="textStyling/changed";gui.DirectFormattingController.paragraphStylingChanged="paragraphStyling/changed";(function(){return gui.DirectFormattingController})();
// Input 81
gui.HyperlinkClickHandler=function(g){function k(){g().removeAttributeNS("urn:webodf:names:helper","links")}function b(){g().setAttributeNS("urn:webodf:names:helper","links","inactive")}var p=gui.HyperlinkClickHandler.Modifier.None,d=gui.HyperlinkClickHandler.Modifier.Ctrl,h=gui.HyperlinkClickHandler.Modifier.Meta,n=new odf.OdfUtils,q=xmldom.XPath,r=p;this.handleClick=function(b){var f=b.target||b.srcElement,c,a;b.ctrlKey?c=d:b.metaKey&&(c=h);if(r===p||r===c){a:{for(;null!==f;){if(n.isHyperlink(f))break a;
if(n.isParagraph(f))break;f=f.parentNode}f=null}f&&(f=n.getHyperlinkTarget(f),""!==f&&("#"===f[0]?(f=f.substring(1),c=g(),a=q.getODFElementsWithXPath(c,"//text:bookmark-start[@text:name='"+f+"']",odf.Namespaces.lookupNamespaceURI),0===a.length&&(a=q.getODFElementsWithXPath(c,"//text:bookmark[@text:name='"+f+"']",odf.Namespaces.lookupNamespaceURI)),0<a.length&&a[0].scrollIntoView(!0)):runtime.getWindow().open(f),b.preventDefault?b.preventDefault():b.returnValue=!1))}};this.showPointerCursor=k;this.showTextCursor=
b;this.setModifier=function(d){r=d;r!==p?b():k()}};gui.HyperlinkClickHandler.Modifier={None:0,Ctrl:1,Meta:2};
// Input 82
gui.HyperlinkController=function(g,k){var b=new odf.OdfUtils,p=g.getOdtDocument();this.addHyperlink=function(b,h){var n=p.getCursorSelection(k),q=new ops.OpApplyHyperlink,r=[];if(0===n.length||h)h=h||b,q=new ops.OpInsertText,q.init({memberid:k,position:n.position,text:h}),n.length=h.length,r.push(q);q=new ops.OpApplyHyperlink;q.init({memberid:k,position:n.position,length:n.length,hyperlink:b});r.push(q);g.enqueue(r)};this.removeHyperlinks=function(){var d=gui.SelectionMover.createPositionIterator(p.getRootNode()),
h=p.getCursor(k).getSelectedRange(),n=b.getHyperlinkElements(h),q=h.collapsed&&1===n.length,r=p.getDOMDocument().createRange(),m=[],f,c;0!==n.length&&(n.forEach(function(a){r.selectNodeContents(a);f=p.convertDomToCursorRange({anchorNode:r.startContainer,anchorOffset:r.startOffset,focusNode:r.endContainer,focusOffset:r.endOffset});c=new ops.OpRemoveHyperlink;c.init({memberid:k,position:f.position,length:f.length});m.push(c)}),q||(q=n[0],-1===h.comparePoint(q,0)&&(r.setStart(q,0),r.setEnd(h.startContainer,
h.startOffset),f=p.convertDomToCursorRange({anchorNode:r.startContainer,anchorOffset:r.startOffset,focusNode:r.endContainer,focusOffset:r.endOffset}),0<f.length&&(c=new ops.OpApplyHyperlink,c.init({memberid:k,position:f.position,length:f.length,hyperlink:b.getHyperlinkTarget(q)}),m.push(c))),n=n[n.length-1],d.moveToEndOfNode(n),d=d.unfilteredDomOffset(),1===h.comparePoint(n,d)&&(r.setStart(h.endContainer,h.endOffset),r.setEnd(n,d),f=p.convertDomToCursorRange({anchorNode:r.startContainer,anchorOffset:r.startOffset,
focusNode:r.endContainer,focusOffset:r.endOffset}),0<f.length&&(c=new ops.OpApplyHyperlink,c.init({memberid:k,position:f.position,length:f.length,hyperlink:b.getHyperlinkTarget(n)}),m.push(c)))),g.enqueue(m),r.detach())}};
// Input 83
gui.EventManager=function(g){function k(){var a=this,b=[];this.filters=[];this.handlers=[];this.handleEvent=function(c){-1===b.indexOf(c)&&(b.push(c),a.filters.every(function(a){return a(c)})&&a.handlers.forEach(function(a){a(c)}),runtime.setTimeout(function(){b.splice(b.indexOf(c),1)},0))}}function b(a){var b=a.scrollX,c=a.scrollY;this.restore=function(){a.scrollX===b&&a.scrollY===c||a.scrollTo(b,c)}}function p(a){var b=a.scrollTop,c=a.scrollLeft;this.restore=function(){if(a.scrollTop!==b||a.scrollLeft!==
c)a.scrollTop=b,a.scrollLeft=c}}function d(a,b,c){var d="on"+b,f=!1;a.attachEvent&&(a.attachEvent(d,c),f=!0);!f&&a.addEventListener&&(a.addEventListener(b,c,!1),f=!0);f&&!m[b]||!a.hasOwnProperty(d)||(a[d]=c)}function h(b,l){var h=c[b]||null,m;!h&&l&&(m=g.getOdfCanvas().getSizer(),h=c[b]=new k,f[b]&&d(r,b,h.handleEvent),d(a,b,h.handleEvent),d(m,b,h.handleEvent));return h}function n(){return g.getDOMDocument().activeElement===a}function q(a){for(var c=[];a;)(a.scrollWidth>a.clientWidth||a.scrollHeight>
a.clientHeight)&&c.push(new p(a)),a=a.parentNode;c.push(new b(r));return c}var r=runtime.getWindow(),m={beforecut:!0,beforepaste:!0},f={mousedown:!0,mouseup:!0,focus:!0},c={},a;this.addFilter=function(a,b){h(a,!0).filters.push(b)};this.removeFilter=function(a,b){var c=h(a,!0),d=c.filters.indexOf(b);-1!==d&&c.filters.splice(d,1)};this.subscribe=function(a,b){h(a,!0).handlers.push(b)};this.unsubscribe=function(a,b){var c=h(a,!1),d=c&&c.handlers.indexOf(b);c&&-1!==d&&c.handlers.splice(d,1)};this.hasFocus=
n;this.focus=function(){var b;n()||(b=q(a),a.focus(),b.forEach(function(a){a.restore()}))};this.getEventTrap=function(){return a};this.blur=function(){n()&&a.blur()};this.destroy=function(b){a.parentNode.removeChild(a);b()};(function(){var b=g.getOdfCanvas().getSizer(),c=b.ownerDocument;runtime.assert(Boolean(r),"EventManager requires a window object to operate correctly");a=c.createElement("input");a.id="eventTrap";a.setAttribute("tabindex",-1);b.appendChild(a)})()};
// Input 84
/*

 Copyright (C) 2014 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.IOSSafariSupport=function(g){function k(){b.innerHeight!==b.outerHeight&&(p.style.display="none",b.requestAnimationFrame(function(){p.style.display="block"}))}var b=runtime.getWindow(),p=g.getEventTrap();this.destroy=function(b){g.unsubscribe("focus",k);p.removeAttribute("autocapitalize");b()};g.subscribe("focus",k);p.setAttribute("autocapitalize","off")};
// Input 85
gui.ImageController=function(g,k,b){var p={"image/gif":".gif","image/jpeg":".jpg","image/png":".png"},d=odf.Namespaces.textns,h=g.getOdtDocument(),n=h.getFormatting(),q={};this.insertImage=function(r,m,f,c){var a;runtime.assert(0<f&&0<c,"Both width and height of the image should be greater than 0px.");a=h.getParagraphElement(h.getCursor(k).getNode()).getAttributeNS(d,"style-name");q.hasOwnProperty(a)||(q[a]=n.getContentSize(a,"paragraph"));a=q[a];f*=0.0264583333333334;c*=0.0264583333333334;var e=
1,l=1;f>a.width&&(e=a.width/f);c>a.height&&(l=a.height/c);e=Math.min(e,l);a=f*e;f=c*e;l=h.getOdfCanvas().odfContainer().rootElement.styles;c=r.toLowerCase();var e=p.hasOwnProperty(c)?p[c]:null,s;c=[];runtime.assert(null!==e,"Image type is not supported: "+r);e="Pictures/"+b.generateImageName()+e;s=new ops.OpSetBlob;s.init({memberid:k,filename:e,mimetype:r,content:m});c.push(s);n.getStyleElement("Graphics","graphic",[l])||(r=new ops.OpAddStyle,r.init({memberid:k,styleName:"Graphics",styleFamily:"graphic",
isAutomaticStyle:!1,setProperties:{"style:graphic-properties":{"text:anchor-type":"paragraph","svg:x":"0cm","svg:y":"0cm","style:wrap":"dynamic","style:number-wrapped-paragraphs":"no-limit","style:wrap-contour":"false","style:vertical-pos":"top","style:vertical-rel":"paragraph","style:horizontal-pos":"center","style:horizontal-rel":"paragraph"}}}),c.push(r));r=b.generateStyleName();m=new ops.OpAddStyle;m.init({memberid:k,styleName:r,styleFamily:"graphic",isAutomaticStyle:!0,setProperties:{"style:parent-style-name":"Graphics",
"style:graphic-properties":{"style:vertical-pos":"top","style:vertical-rel":"baseline","style:horizontal-pos":"center","style:horizontal-rel":"paragraph","fo:background-color":"transparent","style:background-transparency":"100%","style:shadow":"none","style:mirror":"none","fo:clip":"rect(0cm, 0cm, 0cm, 0cm)","draw:luminance":"0%","draw:contrast":"0%","draw:red":"0%","draw:green":"0%","draw:blue":"0%","draw:gamma":"100%","draw:color-inversion":"false","draw:image-opacity":"100%","draw:color-mode":"standard"}}});
c.push(m);s=new ops.OpInsertImage;s.init({memberid:k,position:h.getCursorPosition(k),filename:e,frameWidth:a+"cm",frameHeight:f+"cm",frameStyleName:r,frameName:b.generateFrameName()});c.push(s);g.enqueue(c)}};
// Input 86
gui.ImageSelector=function(g){function k(){var b=g.getSizer(),h=d.createElement("div");h.id="imageSelector";h.style.borderWidth="1px";b.appendChild(h);p.forEach(function(b){var g=d.createElement("div");g.className=b;h.appendChild(g)});return h}var b=odf.Namespaces.svgns,p="topLeft topRight bottomRight bottomLeft topMiddle rightMiddle bottomMiddle leftMiddle".split(" "),d=g.getElement().ownerDocument,h=!1;this.select=function(n){var p,r,m=d.getElementById("imageSelector");m||(m=k());h=!0;p=m.parentNode;
r=n.getBoundingClientRect();var f=p.getBoundingClientRect(),c=g.getZoomLevel();p=(r.left-f.left)/c-1;r=(r.top-f.top)/c-1;m.style.display="block";m.style.left=p+"px";m.style.top=r+"px";m.style.width=n.getAttributeNS(b,"width");m.style.height=n.getAttributeNS(b,"height")};this.clearSelection=function(){var b;h&&(b=d.getElementById("imageSelector"))&&(b.style.display="none");h=!1};this.isSelectorElement=function(b){var h=d.getElementById("imageSelector");return h?b===h||b.parentNode===h:!1}};
// Input 87
(function(){function g(g){function b(b){n=b.which&&String.fromCharCode(b.which)===h;h=void 0;return!1===n}function p(){n=!1}function d(b){h=b.data;n=!1}var h,n=!1;this.destroy=function(h){g.unsubscribe("textInput",p);g.unsubscribe("compositionend",d);g.removeFilter("keypress",b);h()};g.subscribe("textInput",p);g.subscribe("compositionend",d);g.addFilter("keypress",b)}gui.InputMethodEditor=function(k,b){function p(a){l&&(a?l.getNode().setAttributeNS(e,"composing","true"):(l.getNode().removeAttributeNS(e,
"composing"),y.textContent=""))}function d(){u&&(u=!1,p(!1),x.emit(gui.InputMethodEditor.signalCompositionEnd,{data:w}),w="")}function h(){var b=a.getSelection(),c;for(d();1<s.childNodes.length;)s.removeChild(s.firstChild);c=s.firstChild;if(!c||c.nodeType!==Node.TEXT_NODE){for(;s.firstChild;)s.removeChild(s.firstChild);c=s.appendChild(t.createTextNode(""))}l&&l.getSelectedRange().collapsed?c.deleteData(0,c.length):c.replaceData(0,c.length,D);b.collapse(s.firstChild,0);b.extend&&b.extend(s,s.childNodes.length)}
function n(){U=void 0;v.cancel();p(!0);u||x.emit(gui.InputMethodEditor.signalCompositionStart,{data:""})}function q(a){a=U=a.data;u=!0;w+=a;v.trigger()}function r(a){a.data!==U&&(a=a.data,u=!0,w+=a,v.trigger());U=void 0}function m(){y.textContent=s.textContent}function f(){b.blur();s.setAttribute("disabled",!0)}function c(){var a=b.hasFocus();a&&b.blur();T?s.removeAttribute("disabled"):s.setAttribute("disabled",!0);a&&b.focus()}var a=runtime.getWindow(),e="urn:webodf:names:cursor",l=null,s=b.getEventTrap(),
t=s.ownerDocument,y,B=new core.Async,D="b",v,u=!1,w="",x=new core.EventNotifier([gui.InputMethodEditor.signalCompositionStart,gui.InputMethodEditor.signalCompositionEnd]),U,E=[],H,T=!1;this.subscribe=x.subscribe;this.unsubscribe=x.unsubscribe;this.registerCursor=function(a){a.getMemberId()===k&&(l=a,l.getNode().appendChild(y),b.subscribe("input",m),b.subscribe("compositionupdate",m))};this.removeCursor=function(a){l&&a===k&&(l.getNode().removeChild(y),b.unsubscribe("input",m),b.unsubscribe("compositionupdate",
m),l=null)};this.setEditing=function(a){T=a;c()};this.destroy=function(a){b.unsubscribe("compositionstart",n);b.unsubscribe("compositionend",q);b.unsubscribe("textInput",r);b.unsubscribe("keypress",d);b.unsubscribe("mousedown",f);b.unsubscribe("mouseup",c);b.unsubscribe("focus",h);B.destroyAll(H,a)};(function(){b.subscribe("compositionstart",n);b.subscribe("compositionend",q);b.subscribe("textInput",r);b.subscribe("keypress",d);b.subscribe("mousedown",f);b.subscribe("mouseup",c);b.subscribe("focus",
h);E.push(new g(b));H=E.map(function(a){return a.destroy});y=t.createElement("span");y.setAttribute("id","composer");v=new core.ScheduledTask(h,1);H.push(v.destroy)})()};gui.InputMethodEditor.signalCompositionStart="input/compositionstart";gui.InputMethodEditor.signalCompositionEnd="input/compositionend";return gui.InputMethodEditor})();
// Input 88
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.KeyboardHandler=function(){function g(b,h){h||(h=k.None);return b+":"+h}var k=gui.KeyboardHandler.Modifier,b=null,p={};this.setDefault=function(d){b=d};this.bind=function(b,h,k,q){b=g(b,h);runtime.assert(q||!1===p.hasOwnProperty(b),"tried to overwrite the callback handler of key combo: "+b);p[b]=k};this.unbind=function(b,h){var k=g(b,h);delete p[k]};this.reset=function(){b=null;p={}};this.handleEvent=function(d){var h=d.keyCode,n=k.None;d.metaKey&&(n|=k.Meta);d.ctrlKey&&(n|=k.Ctrl);d.altKey&&
(n|=k.Alt);d.shiftKey&&(n|=k.Shift);h=g(h,n);h=p[h];n=!1;h?n=h():null!==b&&(n=b(d));n&&(d.preventDefault?d.preventDefault():d.returnValue=!1)}};gui.KeyboardHandler.Modifier={None:0,Meta:1,Ctrl:2,Alt:4,CtrlAlt:6,Shift:8,MetaShift:9,CtrlShift:10,AltShift:12};
gui.KeyboardHandler.KeyCode={Backspace:8,Tab:9,Clear:12,Enter:13,Ctrl:17,End:35,Home:36,Left:37,Up:38,Right:39,Down:40,Delete:46,A:65,B:66,C:67,D:68,E:69,F:70,G:71,H:72,I:73,J:74,K:75,L:76,M:77,N:78,O:79,P:80,Q:81,R:82,S:83,T:84,U:85,V:86,W:87,X:88,Y:89,Z:90,LeftMeta:91,MetaInMozilla:224};(function(){return gui.KeyboardHandler})();
// Input 89
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.PlainTextPasteboard=function(g,k){function b(b,d){b.init(d);return b}this.createPasteOps=function(p){var d=g.getCursorPosition(k),h=d,n=[];p.replace(/\r/g,"").split("\n").forEach(function(d){n.push(b(new ops.OpSplitParagraph,{memberid:k,position:h,moveCursor:!0}));h+=1;n.push(b(new ops.OpInsertText,{memberid:k,position:h,text:d,moveCursor:!0}));h+=d.length});n.push(b(new ops.OpRemoveText,{memberid:k,position:d,length:1}));return n}};
// Input 90
/*

 Copyright (C) 2014 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
odf.WordBoundaryFilter=function(g,k){function b(a,b,c){for(var d=null,e=g.getRootNode(),f;a!==e&&null!==a&&null===d;)f=0>b?a.previousSibling:a.nextSibling,c(f)===NodeFilter.FILTER_ACCEPT&&(d=f),a=a.parentNode;return d}function p(a,b){var c;return null===a?e.NO_NEIGHBOUR:n.isCharacterElement(a)?e.SPACE_CHAR:a.nodeType===d||n.isTextSpan(a)||n.isHyperlink(a)?(c=a.textContent.charAt(b()),r.test(c)?e.SPACE_CHAR:q.test(c)?e.PUNCTUATION_CHAR:e.WORD_CHAR):e.OTHER}var d=Node.TEXT_NODE,h=Node.ELEMENT_NODE,
n=new odf.OdfUtils,q=/[!-#%-*,-\/:-;?-@\[-\]_{}\u00a1\u00ab\u00b7\u00bb\u00bf;\u00b7\u055a-\u055f\u0589-\u058a\u05be\u05c0\u05c3\u05c6\u05f3-\u05f4\u0609-\u060a\u060c-\u060d\u061b\u061e-\u061f\u066a-\u066d\u06d4\u0700-\u070d\u07f7-\u07f9\u0964-\u0965\u0970\u0df4\u0e4f\u0e5a-\u0e5b\u0f04-\u0f12\u0f3a-\u0f3d\u0f85\u0fd0-\u0fd4\u104a-\u104f\u10fb\u1361-\u1368\u166d-\u166e\u169b-\u169c\u16eb-\u16ed\u1735-\u1736\u17d4-\u17d6\u17d8-\u17da\u1800-\u180a\u1944-\u1945\u19de-\u19df\u1a1e-\u1a1f\u1b5a-\u1b60\u1c3b-\u1c3f\u1c7e-\u1c7f\u2000-\u206e\u207d-\u207e\u208d-\u208e\u3008-\u3009\u2768-\u2775\u27c5-\u27c6\u27e6-\u27ef\u2983-\u2998\u29d8-\u29db\u29fc-\u29fd\u2cf9-\u2cfc\u2cfe-\u2cff\u2e00-\u2e7e\u3000-\u303f\u30a0\u30fb\ua60d-\ua60f\ua673\ua67e\ua874-\ua877\ua8ce-\ua8cf\ua92e-\ua92f\ua95f\uaa5c-\uaa5f\ufd3e-\ufd3f\ufe10-\ufe19\ufe30-\ufe52\ufe54-\ufe61\ufe63\ufe68\ufe6a-\ufe6b\uff01-\uff03\uff05-\uff0a\uff0c-\uff0f\uff1a-\uff1b\uff1f-\uff20\uff3b-\uff3d\uff3f\uff5b\uff5d\uff5f-\uff65]|\ud800[\udd00-\udd01\udf9f\udfd0]|\ud802[\udd1f\udd3f\ude50-\ude58]|\ud809[\udc00-\udc7e]/,
r=/\s/,m=core.PositionFilter.FilterResult.FILTER_ACCEPT,f=core.PositionFilter.FilterResult.FILTER_REJECT,c=odf.WordBoundaryFilter.IncludeWhitespace.TRAILING,a=odf.WordBoundaryFilter.IncludeWhitespace.LEADING,e={NO_NEIGHBOUR:0,SPACE_CHAR:1,PUNCTUATION_CHAR:2,WORD_CHAR:3,OTHER:4};this.acceptPosition=function(d){var g=d.container(),n=d.leftNode(),q=d.rightNode(),r=d.unfilteredDomOffset,D=function(){return d.unfilteredDomOffset()-1};g.nodeType===h&&(null===q&&(q=b(g,1,d.getNodeFilter())),null===n&&(n=
b(g,-1,d.getNodeFilter())));g!==q&&(r=function(){return 0});g!==n&&null!==n&&(D=function(){return n.textContent.length-1});g=p(n,D);q=p(q,r);return g===e.WORD_CHAR&&q===e.WORD_CHAR||g===e.PUNCTUATION_CHAR&&q===e.PUNCTUATION_CHAR||k===c&&g!==e.NO_NEIGHBOUR&&q===e.SPACE_CHAR||k===a&&g===e.SPACE_CHAR&&q!==e.NO_NEIGHBOUR?f:m}};odf.WordBoundaryFilter.IncludeWhitespace={None:0,TRAILING:1,LEADING:2};(function(){return odf.WordBoundaryFilter})();
// Input 91
gui.SelectionController=function(g,k){function b(){var a=B.getCursor(k).getNode();return B.createStepIterator(a,0,[u,x],B.getRootElement(a))}function p(a,b,c){c=new odf.WordBoundaryFilter(B,c);return B.createStepIterator(a,b,[u,x,c],B.getRootElement(a))}function d(a){return function(b){var c=a(b);return function(b,d){return a(d)===c}}}function h(a,b){return b?{anchorNode:a.startContainer,anchorOffset:a.startOffset,focusNode:a.endContainer,focusOffset:a.endOffset}:{anchorNode:a.endContainer,anchorOffset:a.endOffset,
focusNode:a.startContainer,focusOffset:a.startOffset}}function n(a,b,c){var d=new ops.OpMoveCursor;d.init({memberid:k,position:a,length:b||0,selectionType:c});return d}function q(a){var b;b=p(a.startContainer,a.startOffset,U);b.roundToPreviousStep()&&a.setStart(b.container(),b.offset());b=p(a.endContainer,a.endOffset,E);b.roundToNextStep()&&a.setEnd(b.container(),b.offset())}function r(a){var b=v.getParagraphElements(a),c=b[0],b=b[b.length-1];c&&a.setStart(c,0);b&&(v.isParagraph(a.endContainer)&&
0===a.endOffset?a.setEndBefore(b):a.setEnd(b,b.childNodes.length))}function m(a){var b=B.getCursorSelection(k),c=B.getCursor(k).getStepCounter();0!==a&&(a=0<a?c.convertForwardStepsBetweenFilters(a,w,u):-c.convertBackwardStepsBetweenFilters(-a,w,u),a=b.length+a,g.enqueue([n(b.position,a)]))}function f(a){var c=b(),d=B.getCursor(k).getAnchorNode();a(c)&&(a=B.convertDomToCursorRange({anchorNode:d,anchorOffset:0,focusNode:c.container(),focusOffset:c.offset()}),g.enqueue([n(a.position,a.length)]))}function c(a){var b=
B.getCursorPosition(k),c=B.getCursor(k).getStepCounter();0!==a&&(a=0<a?c.convertForwardStepsBetweenFilters(a,w,u):-c.convertBackwardStepsBetweenFilters(-a,w,u),g.enqueue([n(b+a,0)]))}function a(a){var c=b();a(c)&&(a=B.convertDomPointToCursorStep(c.container(),c.offset()),g.enqueue([n(a,0)]))}function e(a,b){var d=B.getParagraphElement(B.getCursor(k).getNode());runtime.assert(Boolean(d),"SelectionController: Cursor outside paragraph");d=B.getCursor(k).getStepCounter().countLinesSteps(a,w);b?m(d):c(d)}
function l(a,b){var d=B.getCursor(k).getStepCounter().countStepsToLineBoundary(a,w);b?m(d):c(d)}function s(a,b){var c=B.getCursor(k),c=h(c.getSelectedRange(),c.hasForwardSelection()),d=p(c.focusNode,c.focusOffset,U);if(0<=a?d.nextStep():d.previousStep())c.focusNode=d.container(),c.focusOffset=d.offset(),b||(c.anchorNode=c.focusNode,c.anchorOffset=c.focusOffset),c=B.convertDomToCursorRange(c),g.enqueue([n(c.position,c.length)])}function t(a,b){var c=B.getCursor(k),e=b(c.getNode()),c=h(c.getSelectedRange(),
c.hasForwardSelection());runtime.assert(Boolean(e),"SelectionController: Cursor outside root");0>a?(c.focusNode=e,c.focusOffset=0):(c.focusNode=e,c.focusOffset=e.childNodes.length);e=B.convertDomToCursorRange(c,d(b));g.enqueue([n(e.position,e.length)])}function y(a){var b=B.getCursor(k),b=B.getRootElement(b.getNode());runtime.assert(Boolean(b),"SelectionController: Cursor outside root");a=0>a?B.convertDomPointToCursorStep(b,0,function(a){return a===ops.StepsTranslator.NEXT_STEP}):B.convertDomPointToCursorStep(b,
b.childNodes.length);g.enqueue([n(a,0)]);return!0}var B=g.getOdtDocument(),D=new core.DomUtils,v=new odf.OdfUtils,u=B.getPositionFilter(),w=new core.PositionFilterChain,x=B.createRootFilter(k),U=odf.WordBoundaryFilter.IncludeWhitespace.TRAILING,E=odf.WordBoundaryFilter.IncludeWhitespace.LEADING;this.selectionToRange=function(a){var b=0<=D.comparePoints(a.anchorNode,a.anchorOffset,a.focusNode,a.focusOffset),c=a.focusNode.ownerDocument.createRange();b?(c.setStart(a.anchorNode,a.anchorOffset),c.setEnd(a.focusNode,
a.focusOffset)):(c.setStart(a.focusNode,a.focusOffset),c.setEnd(a.anchorNode,a.anchorOffset));return{range:c,hasForwardSelection:b}};this.rangeToSelection=h;this.selectImage=function(a){var b=B.getRootElement(a),c=B.createRootFilter(b),b=B.createStepIterator(a,0,[c,B.getPositionFilter()],b),d;b.roundToPreviousStep()||runtime.assert(!1,"No walkable position before frame");c=b.container();d=b.offset();b.setPosition(a,a.childNodes.length);b.roundToNextStep()||runtime.assert(!1,"No walkable position after frame");
a=B.convertDomToCursorRange({anchorNode:c,anchorOffset:d,focusNode:b.container(),focusOffset:b.offset()});a=n(a.position,a.length,ops.OdtCursor.RegionSelection);g.enqueue([a])};this.expandToWordBoundaries=q;this.expandToParagraphBoundaries=r;this.selectRange=function(a,b,c){var e=B.getOdfCanvas().getElement(),f;f=D.containsNode(e,a.startContainer);e=D.containsNode(e,a.endContainer);if(f||e)if(f&&e&&(2===c?q(a):3<=c&&r(a)),a=h(a,b),b=B.convertDomToCursorRange(a,d(v.getParagraphElement)),a=B.getCursorSelection(k),
b.position!==a.position||b.length!==a.length)a=n(b.position,b.length,ops.OdtCursor.RangeSelection),g.enqueue([a])};this.moveCursorToLeft=function(){a(function(a){return a.previousStep()});return!0};this.moveCursorToRight=function(){a(function(a){return a.nextStep()});return!0};this.extendSelectionToLeft=function(){f(function(a){return a.previousStep()});return!0};this.extendSelectionToRight=function(){f(function(a){return a.nextStep()});return!0};this.moveCursorUp=function(){e(-1,!1);return!0};this.moveCursorDown=
function(){e(1,!1);return!0};this.extendSelectionUp=function(){e(-1,!0);return!0};this.extendSelectionDown=function(){e(1,!0);return!0};this.moveCursorBeforeWord=function(){s(-1,!1);return!0};this.moveCursorPastWord=function(){s(1,!1);return!0};this.extendSelectionBeforeWord=function(){s(-1,!0);return!0};this.extendSelectionPastWord=function(){s(1,!0);return!0};this.moveCursorToLineStart=function(){l(-1,!1);return!0};this.moveCursorToLineEnd=function(){l(1,!1);return!0};this.extendSelectionToLineStart=
function(){l(-1,!0);return!0};this.extendSelectionToLineEnd=function(){l(1,!0);return!0};this.extendSelectionToParagraphStart=function(){t(-1,B.getParagraphElement);return!0};this.extendSelectionToParagraphEnd=function(){t(1,B.getParagraphElement);return!0};this.moveCursorToDocumentStart=function(){y(-1);return!0};this.moveCursorToDocumentEnd=function(){y(1);return!0};this.extendSelectionToDocumentStart=function(){t(-1,B.getRootElement);return!0};this.extendSelectionToDocumentEnd=function(){t(1,B.getRootElement);
return!0};this.extendSelectionToEntireDocument=function(){var a=B.getCursor(k),a=B.getRootElement(a.getNode());runtime.assert(Boolean(a),"SelectionController: Cursor outside root");a=B.convertDomToCursorRange({anchorNode:a,anchorOffset:0,focusNode:a,focusOffset:a.childNodes.length},d(B.getRootElement));g.enqueue([n(a.position,a.length)]);return!0};w.addFilter(u);w.addFilter(B.createRootFilter(k))};
// Input 92
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.TextController=function(g,k,b,p){function d(b){var d=new ops.OpRemoveText;d.init({memberid:k,position:b.position,length:b.length});return d}function h(b){0>b.length&&(b.position+=b.length,b.length=-b.length);return b}function n(b,d){var c=new core.PositionFilterChain,a=gui.SelectionMover.createPositionIterator(q.getRootElement(b)),e=d?a.nextPosition:a.previousPosition;c.addFilter(q.getPositionFilter());c.addFilter(q.createRootFilter(k));for(a.setUnfilteredPosition(b,0);e();)if(c.acceptPosition(a)===
r)return!0;return!1}var q=g.getOdtDocument(),r=core.PositionFilter.FilterResult.FILTER_ACCEPT;this.enqueueParagraphSplittingOps=function(){var b=h(q.getCursorSelection(k)),f,c=[];0<b.length&&(f=d(b),c.push(f));f=new ops.OpSplitParagraph;f.init({memberid:k,position:b.position,moveCursor:!0});c.push(f);p&&(b=p(b.position+1),c=c.concat(b));g.enqueue(c);return!0};this.removeTextByBackspaceKey=function(){var b=q.getCursor(k),f=h(q.getCursorSelection(k)),c=null;0===f.length?n(b.getNode(),!1)&&(c=new ops.OpRemoveText,
c.init({memberid:k,position:f.position-1,length:1}),g.enqueue([c])):(c=d(f),g.enqueue([c]));return null!==c};this.removeTextByDeleteKey=function(){var b=q.getCursor(k),f=h(q.getCursorSelection(k)),c=null;0===f.length?n(b.getNode(),!0)&&(c=new ops.OpRemoveText,c.init({memberid:k,position:f.position,length:1}),g.enqueue([c])):(c=d(f),g.enqueue([c]));return null!==c};this.removeCurrentSelection=function(){var b=h(q.getCursorSelection(k));0!==b.length&&(b=d(b),g.enqueue([b]));return!0};this.insertText=
function(m){var f=h(q.getCursorSelection(k)),c,a=[],e=!1;0<f.length&&(c=d(f),a.push(c),e=!0);c=new ops.OpInsertText;c.init({memberid:k,position:f.position,text:m,moveCursor:!0});a.push(c);b&&(m=b(f.position,m.length,e))&&a.push(m);g.enqueue(a)}};(function(){return gui.TextController})();
// Input 93
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.UndoManager=function(){};gui.UndoManager.prototype.subscribe=function(g,k){};gui.UndoManager.prototype.unsubscribe=function(g,k){};gui.UndoManager.prototype.setDocument=function(g){};gui.UndoManager.prototype.setInitialState=function(){};gui.UndoManager.prototype.initialize=function(){};gui.UndoManager.prototype.purgeInitialState=function(){};gui.UndoManager.prototype.setPlaybackFunction=function(g){};gui.UndoManager.prototype.hasUndoStates=function(){};
gui.UndoManager.prototype.hasRedoStates=function(){};gui.UndoManager.prototype.moveForward=function(g){};gui.UndoManager.prototype.moveBackward=function(g){};gui.UndoManager.prototype.onOperationExecuted=function(g){};gui.UndoManager.signalUndoStackChanged="undoStackChanged";gui.UndoManager.signalUndoStateCreated="undoStateCreated";gui.UndoManager.signalUndoStateModified="undoStateModified";(function(){return gui.UndoManager})();
// Input 94
(function(){var g=core.PositionFilter.FilterResult.FILTER_ACCEPT;gui.SessionController=function(k,b,p,d){function h(a){var c=F.getCursor(b).getSelectedRange();c.collapsed?a.preventDefault():R.setDataFromRange(a,c)?$.removeCurrentSelection():runtime.log("Cut operation failed")}function n(){return!1!==F.getCursor(b).getSelectedRange().collapsed}function q(a){var c=F.getCursor(b).getSelectedRange();c.collapsed?a.preventDefault():R.setDataFromRange(a,c)||runtime.log("Copy operation failed")}function r(a){var b;
T.clipboardData&&T.clipboardData.getData?b=T.clipboardData.getData("Text"):a.clipboardData&&a.clipboardData.getData&&(b=a.clipboardData.getData("text/plain"));b&&($.removeCurrentSelection(),k.enqueue(ja.createPasteOps(b)));a.preventDefault?a.preventDefault():a.returnValue=!1}function m(){return!1}function f(a){if(I)I.onOperationExecuted(a)}function c(a){F.emit(ops.OdtDocument.signalUndoStackChanged,a)}function a(){var a=J.getEventTrap(),b,c;return I?(c=J.hasFocus(),I.moveBackward(1),b=F.getOdfCanvas().getSizer(),
ba.containsNode(b,a)||(b.appendChild(a),c&&J.focus()),!0):!1}function e(){var a;return I?(a=J.hasFocus(),I.moveForward(1),a&&J.focus(),!0):!1}function l(){var a=T.getSelection(),b=0<a.rangeCount&&P.selectionToRange(a);L&&b&&(Q=!0,S.clearSelection(),M.setUnfilteredPosition(a.focusNode,a.focusOffset),ga.acceptPosition(M)===g&&(2===da?P.expandToWordBoundaries(b.range):3<=da&&P.expandToParagraphBoundaries(b.range),p.setSelectedRange(b.range,b.hasForwardSelection),F.emit(ops.Document.signalCursorMoved,
p)))}function s(a){var c=a.target||a.srcElement||null,d=F.getCursor(b);if(L=null!==c&&ba.containsNode(F.getOdfCanvas().getElement(),c))Q=!1,ga=F.createRootFilter(c),da=a.detail,d&&a.shiftKey?T.getSelection().collapse(d.getAnchorNode(),0):(a=T.getSelection(),c=d.getSelectedRange(),a.extend?d.hasForwardSelection()?(a.collapse(c.startContainer,c.startOffset),a.extend(c.endContainer,c.endOffset)):(a.collapse(c.endContainer,c.endOffset),a.extend(c.startContainer,c.startOffset)):(a.removeAllRanges(),a.addRange(c.cloneRange()))),
1<da&&l()}function t(a){var b=F.getRootElement(a),c=F.createRootFilter(b),b=F.createStepIterator(a,0,[c,F.getPositionFilter()],b);b.setPosition(a,a.childNodes.length);return b.roundToNextStep()?{container:b.container(),offset:b.offset()}:null}function y(a){var b;b=(b=T.getSelection())?{anchorNode:b.anchorNode,anchorOffset:b.anchorOffset,focusNode:b.focusNode,focusOffset:b.focusOffset}:null;var c,d;if(!b.anchorNode&&!b.focusNode){d=a.clientX;var e=a.clientY,f=F.getDOMDocument();c=null;f.caretRangeFromPoint?
(d=f.caretRangeFromPoint(d,e),c={container:d.startContainer,offset:d.startOffset}):f.caretPositionFromPoint&&(d=f.caretPositionFromPoint(d,e))&&d.offsetNode&&(c={container:d.offsetNode,offset:d.offset});c&&(b.anchorNode=c.container,b.anchorOffset=c.offset,b.focusNode=b.anchorNode,b.focusOffset=b.anchorOffset)}if(N.isImage(b.focusNode)&&0===b.focusOffset&&N.isCharacterFrame(b.focusNode.parentNode)){if(d=b.focusNode.parentNode,c=d.getBoundingClientRect(),a.clientX>c.right&&(c=t(d)))b.anchorNode=b.focusNode=
c.container,b.anchorOffset=b.focusOffset=c.offset}else N.isImage(b.focusNode.firstChild)&&1===b.focusOffset&&N.isCharacterFrame(b.focusNode)&&(c=t(b.focusNode))&&(b.anchorNode=b.focusNode=c.container,b.anchorOffset=b.focusOffset=c.offset);b.anchorNode&&b.focusNode&&(b=P.selectionToRange(b),P.selectRange(b.range,b.hasForwardSelection,a.detail));J.focus()}function B(a){var b=a.target||a.srcElement||null,c,d;Y.processRequests();N.isImage(b)&&N.isCharacterFrame(b.parentNode)&&T.getSelection().isCollapsed?
(P.selectImage(b.parentNode),J.focus()):S.isSelectorElement(b)?J.focus():L&&(Q?(b=p.getSelectedRange(),c=b.collapsed,N.isImage(b.endContainer)&&0===b.endOffset&&N.isCharacterFrame(b.endContainer.parentNode)&&(d=b.endContainer.parentNode,d=t(d))&&(b.setEnd(d.container,d.offset),c&&b.collapse(!1)),P.selectRange(b,p.hasForwardSelection(),a.detail),J.focus()):ma?y(a):W=runtime.setTimeout(function(){y(a)},0));da=0;Q=L=!1}function D(a){var c=F.getCursor(b).getSelectedRange();c.collapsed||G.exportRangeToDataTransfer(a.dataTransfer,
c)}function v(){L&&J.focus();da=0;Q=L=!1}function u(a){B(a)}function w(a){var b=a.target||a.srcElement||null,c=null;"annotationRemoveButton"===b.className?(c=ba.getElementsByTagNameNS(b.parentNode,odf.Namespaces.officens,"annotation")[0],V.removeAnnotation(c),J.focus()):B(a)}function x(a){(a=a.data)&&$.insertText(a)}function U(a){return function(){a();return!0}}function E(a){return function(c){return F.getCursor(b).getSelectionType()===ops.OdtCursor.RangeSelection?a(c):!0}}function H(a){J.unsubscribe("keydown",
z.handleEvent);J.unsubscribe("keypress",fa.handleEvent);J.unsubscribe("keyup",ea.handleEvent);J.unsubscribe("copy",q);J.unsubscribe("mousedown",s);J.unsubscribe("mousemove",Y.trigger);J.unsubscribe("mouseup",w);J.unsubscribe("contextmenu",u);J.unsubscribe("dragstart",D);J.unsubscribe("dragend",v);J.unsubscribe("click",ha.handleClick);F.unsubscribe(ops.OdtDocument.signalOperationEnd,ia.trigger);F.unsubscribe(ops.Document.signalCursorAdded,ca.registerCursor);F.unsubscribe(ops.Document.signalCursorRemoved,
ca.removeCursor);F.unsubscribe(ops.OdtDocument.signalOperationEnd,f);a()}var T=runtime.getWindow(),F=k.getOdtDocument(),Z=new core.Async,ba=new core.DomUtils,N=new odf.OdfUtils,G=new gui.MimeDataExporter,R=new gui.Clipboard(G),z=new gui.KeyboardHandler,fa=new gui.KeyboardHandler,ea=new gui.KeyboardHandler,L=!1,K=new odf.ObjectNameGenerator(F.getOdfCanvas().odfContainer(),b),Q=!1,ga=null,W,I=null,J=new gui.EventManager(F),V=new gui.AnnotationController(k,b),O=new gui.DirectFormattingController(k,b,
K,d.directParagraphStylingEnabled),$=new gui.TextController(k,b,O.createCursorStyleOp,O.createParagraphStyleOps),na=new gui.ImageController(k,b,K),S=new gui.ImageSelector(F.getOdfCanvas()),M=gui.SelectionMover.createPositionIterator(F.getRootNode()),Y,ia,ja=new gui.PlainTextPasteboard(F,b),ca=new gui.InputMethodEditor(b,J),da=0,ha=new gui.HyperlinkClickHandler(F.getRootNode),aa=new gui.HyperlinkController(k,b),P=new gui.SelectionController(k,b),A=gui.KeyboardHandler.Modifier,C=gui.KeyboardHandler.KeyCode,
ka=-1!==T.navigator.appVersion.toLowerCase().indexOf("mac"),ma=-1!==["iPad","iPod","iPhone"].indexOf(T.navigator.platform),la;runtime.assert(null!==T,"Expected to be run in an environment which has a global window, like a browser.");this.insertLocalCursor=function(){runtime.assert(void 0===k.getOdtDocument().getCursor(b),"Inserting local cursor a second time.");var a=new ops.OpAddCursor;a.init({memberid:b});k.enqueue([a]);J.focus()};this.removeLocalCursor=function(){runtime.assert(void 0!==k.getOdtDocument().getCursor(b),
"Removing local cursor without inserting before.");var a=new ops.OpRemoveCursor;a.init({memberid:b});k.enqueue([a])};this.startEditing=function(){ca.subscribe(gui.InputMethodEditor.signalCompositionStart,$.removeCurrentSelection);ca.subscribe(gui.InputMethodEditor.signalCompositionEnd,x);J.subscribe("beforecut",n);J.subscribe("cut",h);J.subscribe("beforepaste",m);J.subscribe("paste",r);T.addEventListener("focus",ha.showTextCursor,!1);I&&I.initialize();ca.setEditing(!0);ha.setModifier(ka?gui.HyperlinkClickHandler.Modifier.Meta:
gui.HyperlinkClickHandler.Modifier.Ctrl);z.bind(C.Backspace,A.None,U($.removeTextByBackspaceKey),!0);z.bind(C.Delete,A.None,$.removeTextByDeleteKey);z.bind(C.Tab,A.None,E(function(){$.insertText("\t");return!0}));ka?(z.bind(C.Clear,A.None,$.removeCurrentSelection),z.bind(C.B,A.Meta,E(O.toggleBold)),z.bind(C.I,A.Meta,E(O.toggleItalic)),z.bind(C.U,A.Meta,E(O.toggleUnderline)),z.bind(C.L,A.MetaShift,E(O.alignParagraphLeft)),z.bind(C.E,A.MetaShift,E(O.alignParagraphCenter)),z.bind(C.R,A.MetaShift,E(O.alignParagraphRight)),
z.bind(C.J,A.MetaShift,E(O.alignParagraphJustified)),z.bind(C.C,A.MetaShift,V.addAnnotation),z.bind(C.Z,A.Meta,a),z.bind(C.Z,A.MetaShift,e),z.bind(C.LeftMeta,A.Meta,ha.showPointerCursor),z.bind(C.MetaInMozilla,A.Meta,ha.showPointerCursor),ea.bind(C.LeftMeta,A.None,ha.showTextCursor),ea.bind(C.MetaInMozilla,A.None,ha.showTextCursor)):(z.bind(C.B,A.Ctrl,E(O.toggleBold)),z.bind(C.I,A.Ctrl,E(O.toggleItalic)),z.bind(C.U,A.Ctrl,E(O.toggleUnderline)),z.bind(C.L,A.CtrlShift,E(O.alignParagraphLeft)),z.bind(C.E,
A.CtrlShift,E(O.alignParagraphCenter)),z.bind(C.R,A.CtrlShift,E(O.alignParagraphRight)),z.bind(C.J,A.CtrlShift,E(O.alignParagraphJustified)),z.bind(C.C,A.CtrlAlt,V.addAnnotation),z.bind(C.Z,A.Ctrl,a),z.bind(C.Z,A.CtrlShift,e),z.bind(C.Ctrl,A.Ctrl,ha.showPointerCursor),ea.bind(C.Ctrl,A.None,ha.showTextCursor));fa.setDefault(E(function(a){var b;b=null===a.which||void 0===a.which?String.fromCharCode(a.keyCode):0!==a.which&&0!==a.charCode?String.fromCharCode(a.which):null;return!b||a.altKey||a.ctrlKey||
a.metaKey?!1:($.insertText(b),!0)}));fa.bind(C.Enter,A.None,E($.enqueueParagraphSplittingOps))};this.endEditing=function(){ca.unsubscribe(gui.InputMethodEditor.signalCompositionStart,$.removeCurrentSelection);ca.unsubscribe(gui.InputMethodEditor.signalCompositionEnd,x);J.unsubscribe("cut",h);J.unsubscribe("beforecut",n);J.unsubscribe("paste",r);J.unsubscribe("beforepaste",m);T.removeEventListener("focus",ha.showTextCursor,!1);ca.setEditing(!1);ha.setModifier(gui.HyperlinkClickHandler.Modifier.None);
z.bind(C.Backspace,A.None,function(){return!0},!0);z.unbind(C.Delete,A.None);z.unbind(C.Tab,A.None);ka?(z.unbind(C.Clear,A.None),z.unbind(C.B,A.Meta),z.unbind(C.I,A.Meta),z.unbind(C.U,A.Meta),z.unbind(C.L,A.MetaShift),z.unbind(C.E,A.MetaShift),z.unbind(C.R,A.MetaShift),z.unbind(C.J,A.MetaShift),z.unbind(C.C,A.MetaShift),z.unbind(C.Z,A.Meta),z.unbind(C.Z,A.MetaShift),z.unbind(C.LeftMeta,A.Meta),z.unbind(C.MetaInMozilla,A.Meta),ea.unbind(C.LeftMeta,A.None),ea.unbind(C.MetaInMozilla,A.None)):(z.unbind(C.B,
A.Ctrl),z.unbind(C.I,A.Ctrl),z.unbind(C.U,A.Ctrl),z.unbind(C.L,A.CtrlShift),z.unbind(C.E,A.CtrlShift),z.unbind(C.R,A.CtrlShift),z.unbind(C.J,A.CtrlShift),z.unbind(C.C,A.CtrlAlt),z.unbind(C.Z,A.Ctrl),z.unbind(C.Z,A.CtrlShift),z.unbind(C.Ctrl,A.Ctrl),ea.unbind(C.Ctrl,A.None));fa.setDefault(null);fa.unbind(C.Enter,A.None)};this.getInputMemberId=function(){return b};this.getSession=function(){return k};this.setUndoManager=function(a){I&&I.unsubscribe(gui.UndoManager.signalUndoStackChanged,c);if(I=a)I.setDocument(F),
I.setPlaybackFunction(k.enqueue),I.subscribe(gui.UndoManager.signalUndoStackChanged,c)};this.getUndoManager=function(){return I};this.getAnnotationController=function(){return V};this.getDirectFormattingController=function(){return O};this.getHyperlinkController=function(){return aa};this.getImageController=function(){return na};this.getSelectionController=function(){return P};this.getTextController=function(){return $};this.getEventManager=function(){return J};this.getKeyboardHandlers=function(){return{keydown:z,
keypress:fa}};this.destroy=function(a){var b=[];la&&b.push(la.destroy);b=b.concat([Y.destroy,ia.destroy,O.destroy,ca.destroy,J.destroy,H]);runtime.clearTimeout(W);Z.destroyAll(b,a)};Y=new core.ScheduledTask(l,0);ia=new core.ScheduledTask(function(){var a=F.getCursor(b);if(a&&a.getSelectionType()===ops.OdtCursor.RegionSelection&&(a=N.getImageElements(a.getSelectedRange())[0])){S.select(a.parentNode);return}S.clearSelection()},0);z.bind(C.Left,A.None,E(P.moveCursorToLeft));z.bind(C.Right,A.None,E(P.moveCursorToRight));
z.bind(C.Up,A.None,E(P.moveCursorUp));z.bind(C.Down,A.None,E(P.moveCursorDown));z.bind(C.Left,A.Shift,E(P.extendSelectionToLeft));z.bind(C.Right,A.Shift,E(P.extendSelectionToRight));z.bind(C.Up,A.Shift,E(P.extendSelectionUp));z.bind(C.Down,A.Shift,E(P.extendSelectionDown));z.bind(C.Home,A.None,E(P.moveCursorToLineStart));z.bind(C.End,A.None,E(P.moveCursorToLineEnd));z.bind(C.Home,A.Ctrl,E(P.moveCursorToDocumentStart));z.bind(C.End,A.Ctrl,E(P.moveCursorToDocumentEnd));z.bind(C.Home,A.Shift,E(P.extendSelectionToLineStart));
z.bind(C.End,A.Shift,E(P.extendSelectionToLineEnd));z.bind(C.Up,A.CtrlShift,E(P.extendSelectionToParagraphStart));z.bind(C.Down,A.CtrlShift,E(P.extendSelectionToParagraphEnd));z.bind(C.Home,A.CtrlShift,E(P.extendSelectionToDocumentStart));z.bind(C.End,A.CtrlShift,E(P.extendSelectionToDocumentEnd));ka?(z.bind(C.Left,A.Alt,E(P.moveCursorBeforeWord)),z.bind(C.Right,A.Alt,E(P.moveCursorPastWord)),z.bind(C.Left,A.Meta,E(P.moveCursorToLineStart)),z.bind(C.Right,A.Meta,E(P.moveCursorToLineEnd)),z.bind(C.Home,
A.Meta,E(P.moveCursorToDocumentStart)),z.bind(C.End,A.Meta,E(P.moveCursorToDocumentEnd)),z.bind(C.Left,A.AltShift,E(P.extendSelectionBeforeWord)),z.bind(C.Right,A.AltShift,E(P.extendSelectionPastWord)),z.bind(C.Left,A.MetaShift,E(P.extendSelectionToLineStart)),z.bind(C.Right,A.MetaShift,E(P.extendSelectionToLineEnd)),z.bind(C.Up,A.AltShift,E(P.extendSelectionToParagraphStart)),z.bind(C.Down,A.AltShift,E(P.extendSelectionToParagraphEnd)),z.bind(C.Up,A.MetaShift,E(P.extendSelectionToDocumentStart)),
z.bind(C.Down,A.MetaShift,E(P.extendSelectionToDocumentEnd)),z.bind(C.A,A.Meta,E(P.extendSelectionToEntireDocument))):(z.bind(C.Left,A.Ctrl,E(P.moveCursorBeforeWord)),z.bind(C.Right,A.Ctrl,E(P.moveCursorPastWord)),z.bind(C.Left,A.CtrlShift,E(P.extendSelectionBeforeWord)),z.bind(C.Right,A.CtrlShift,E(P.extendSelectionPastWord)),z.bind(C.A,A.Ctrl,E(P.extendSelectionToEntireDocument)));ma&&(la=new gui.IOSSafariSupport(J));J.subscribe("keydown",z.handleEvent);J.subscribe("keypress",fa.handleEvent);J.subscribe("keyup",
ea.handleEvent);J.subscribe("copy",q);J.subscribe("mousedown",s);J.subscribe("mousemove",Y.trigger);J.subscribe("mouseup",w);J.subscribe("contextmenu",u);J.subscribe("dragstart",D);J.subscribe("dragend",v);J.subscribe("click",ha.handleClick);F.subscribe(ops.OdtDocument.signalOperationEnd,ia.trigger);F.subscribe(ops.Document.signalCursorAdded,ca.registerCursor);F.subscribe(ops.Document.signalCursorRemoved,ca.removeCursor);F.subscribe(ops.OdtDocument.signalOperationEnd,f)};return gui.SessionController})();
// Input 95
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.CaretManager=function(g){function k(b){return a.hasOwnProperty(b)?a[b]:null}function b(){return Object.keys(a).map(function(b){return a[b]})}function p(b){var c=a[b];c&&(c.destroy(function(){}),delete a[b])}function d(a){a=a.getMemberId();a===g.getInputMemberId()&&(a=k(a))&&a.refreshCursorBlinking()}function h(){var a=k(g.getInputMemberId());t=!1;a&&a.ensureVisible()}function n(){var a=k(g.getInputMemberId());a&&(a.handleUpdate(),t||(t=!0,s=runtime.setTimeout(h,50)))}function q(a){a.memberId===
g.getInputMemberId()&&n()}function r(){var a=k(g.getInputMemberId());a&&a.setFocus()}function m(){var a=k(g.getInputMemberId());a&&a.removeFocus()}function f(){var a=k(g.getInputMemberId());a&&a.show()}function c(){var a=k(g.getInputMemberId());a&&a.hide()}var a={},e=new core.Async,l=runtime.getWindow(),s,t=!1;this.registerCursor=function(b,c,d){var e=b.getMemberId();c=new gui.Caret(b,c,d);d=g.getEventManager();a[e]=c;e===g.getInputMemberId()?(runtime.log("Starting to track input on new cursor of "+
e),b.subscribe(ops.OdtCursor.signalCursorUpdated,n),c.setOverlayElement(d.getEventTrap())):b.subscribe(ops.OdtCursor.signalCursorUpdated,c.handleUpdate);return c};this.getCaret=k;this.getCarets=b;this.destroy=function(h){var k=g.getSession().getOdtDocument(),n=g.getEventManager(),t=b().map(function(a){return a.destroy});runtime.clearTimeout(s);k.unsubscribe(ops.OdtDocument.signalParagraphChanged,q);k.unsubscribe(ops.Document.signalCursorMoved,d);k.unsubscribe(ops.Document.signalCursorRemoved,p);n.unsubscribe("focus",
r);n.unsubscribe("blur",m);l.removeEventListener("focus",f,!1);l.removeEventListener("blur",c,!1);a={};e.destroyAll(t,h)};(function(){var a=g.getSession().getOdtDocument(),b=g.getEventManager();a.subscribe(ops.OdtDocument.signalParagraphChanged,q);a.subscribe(ops.Document.signalCursorMoved,d);a.subscribe(ops.Document.signalCursorRemoved,p);b.subscribe("focus",r);b.subscribe("blur",m);l.addEventListener("focus",f,!1);l.addEventListener("blur",c,!1)})()};
// Input 96
gui.EditInfoHandle=function(g){var k=[],b,p=g.ownerDocument,d=p.documentElement.namespaceURI;this.setEdits=function(g){k=g;var n,q,r,m;b.innerHTML="";for(g=0;g<k.length;g+=1)n=p.createElementNS(d,"div"),n.className="editInfo",q=p.createElementNS(d,"span"),q.className="editInfoColor",q.setAttributeNS("urn:webodf:names:editinfo","editinfo:memberid",k[g].memberid),r=p.createElementNS(d,"span"),r.className="editInfoAuthor",r.setAttributeNS("urn:webodf:names:editinfo","editinfo:memberid",k[g].memberid),
m=p.createElementNS(d,"span"),m.className="editInfoTime",m.setAttributeNS("urn:webodf:names:editinfo","editinfo:memberid",k[g].memberid),m.innerHTML=k[g].time,n.appendChild(q),n.appendChild(r),n.appendChild(m),b.appendChild(n)};this.show=function(){b.style.display="block"};this.hide=function(){b.style.display="none"};this.destroy=function(d){g.removeChild(b);d()};b=p.createElementNS(d,"div");b.setAttribute("class","editInfoHandle");b.style.display="none";g.appendChild(b)};
// Input 97
/*

 Copyright (C) 2012 KO GmbH <aditya.bhatt@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.EditInfo=function(g,k){function b(){var b=[],g;for(g in d)d.hasOwnProperty(g)&&b.push({memberid:g,time:d[g].time});b.sort(function(b,d){return b.time-d.time});return b}var p,d={};this.getNode=function(){return p};this.getOdtDocument=function(){return k};this.getEdits=function(){return d};this.getSortedEdits=function(){return b()};this.addEdit=function(b,g){d[b]={time:g}};this.clearEdits=function(){d={}};this.destroy=function(b){g.parentNode&&g.removeChild(p);b()};p=k.getDOMDocument().createElementNS("urn:webodf:names:editinfo",
"editinfo");g.insertBefore(p,g.firstChild)};
// Input 98
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.EditInfoMarker=function(g,k){function b(b,c){return runtime.setTimeout(function(){n.style.opacity=b},c)}var p=this,d,h,n,q,r,m;this.addEdit=function(d,c){var a=Date.now()-c;g.addEdit(d,c);h.setEdits(g.getSortedEdits());n.setAttributeNS("urn:webodf:names:editinfo","editinfo:memberid",d);runtime.clearTimeout(r);runtime.clearTimeout(m);1E4>a?(q=b(1,0),r=b(0.5,1E4-a),m=b(0.2,2E4-a)):1E4<=a&&2E4>a?(q=b(0.5,0),m=b(0.2,2E4-a)):q=b(0.2,0)};this.getEdits=function(){return g.getEdits()};this.clearEdits=
function(){g.clearEdits();h.setEdits([]);n.hasAttributeNS("urn:webodf:names:editinfo","editinfo:memberid")&&n.removeAttributeNS("urn:webodf:names:editinfo","editinfo:memberid")};this.getEditInfo=function(){return g};this.show=function(){n.style.display="block"};this.hide=function(){p.hideHandle();n.style.display="none"};this.showHandle=function(){h.show()};this.hideHandle=function(){h.hide()};this.destroy=function(b){runtime.clearTimeout(q);runtime.clearTimeout(r);runtime.clearTimeout(m);d.removeChild(n);
h.destroy(function(c){c?b(c):g.destroy(b)})};(function(){var b=g.getOdtDocument().getDOMDocument();n=b.createElementNS(b.documentElement.namespaceURI,"div");n.setAttribute("class","editInfoMarker");n.onmouseover=function(){p.showHandle()};n.onmouseout=function(){p.hideHandle()};d=g.getNode();d.appendChild(n);h=new gui.EditInfoHandle(d);k||p.hide()})()};
// Input 99
gui.ShadowCursor=function(g){var k=g.getDOMDocument().createRange(),b=!0;this.removeFromDocument=function(){};this.getMemberId=function(){return gui.ShadowCursor.ShadowCursorMemberId};this.getSelectedRange=function(){return k};this.setSelectedRange=function(g,d){k=g;b=!1!==d};this.hasForwardSelection=function(){return b};this.getDocument=function(){return g};this.getSelectionType=function(){return ops.OdtCursor.RangeSelection};k.setStart(g.getRootNode(),0)};gui.ShadowCursor.ShadowCursorMemberId="";
(function(){return gui.ShadowCursor})();
// Input 100
gui.SelectionView=function(g){};gui.SelectionView.prototype.rerender=function(){};gui.SelectionView.prototype.show=function(){};gui.SelectionView.prototype.hide=function(){};gui.SelectionView.prototype.destroy=function(g){};
// Input 101
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.SelectionViewManager=function(g){function k(){return Object.keys(b).map(function(g){return b[g]})}var b={};this.getSelectionView=function(g){return b.hasOwnProperty(g)?b[g]:null};this.getSelectionViews=k;this.removeSelectionView=function(g){b.hasOwnProperty(g)&&(b[g].destroy(function(){}),delete b[g])};this.hideSelectionView=function(g){b.hasOwnProperty(g)&&b[g].hide()};this.showSelectionView=function(g){b.hasOwnProperty(g)&&b[g].show()};this.rerenderSelectionViews=function(){Object.keys(b).forEach(function(g){b[g].rerender()})};
this.registerCursor=function(k,d){var h=k.getMemberId(),n=new g(k);d?n.show():n.hide();return b[h]=n};this.destroy=function(b){function d(k,q){q?b(q):k<g.length?g[k].destroy(function(b){d(k+1,b)}):b()}var g=k();d(0,void 0)}};
// Input 102
/*

 Copyright (C) 2012-2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.SessionViewOptions=function(){this.caretBlinksOnRangeSelect=this.caretAvatarsInitiallyVisible=this.editInfoMarkersInitiallyVisible=!0};
(function(){gui.SessionView=function(g,k,b,p,d){function h(a,b,c){function d(b,c,f){c=b+'[editinfo|memberid="'+a+'"]'+f+c;a:{var g=e.firstChild;for(b=b+'[editinfo|memberid="'+a+'"]'+f+"{";g;){if(g.nodeType===Node.TEXT_NODE&&0===g.data.indexOf(b)){b=g;break a}g=g.nextSibling}b=null}b?b.data=c:e.appendChild(document.createTextNode(c))}d("div.editInfoMarker","{ background-color: "+c+"; }","");d("span.editInfoColor","{ background-color: "+c+"; }","");d("span.editInfoAuthor",'{ content: "'+b+'"; }',":before");
d("dc|creator","{ background-color: "+c+"; }","");d(".selectionOverlay","{ fill: "+c+"; stroke: "+c+";}","")}function n(a){var b,c;for(c in s)s.hasOwnProperty(c)&&(b=s[c],a?b.show():b.hide())}function q(a){p.getCarets().forEach(function(b){a?b.showHandle():b.hideHandle()})}function r(a){var b=a.getMemberId();a=a.getProperties();h(b,a.fullName,a.color);k===b&&h("","",a.color)}function m(a){var c=a.getMemberId(),e=b.getOdtDocument().getMember(c).getProperties();p.registerCursor(a,y,B);d.registerCursor(a,
!0);if(a=p.getCaret(c))a.setAvatarImageUrl(e.imageUrl),a.setColor(e.color);runtime.log("+++ View here +++ eagerly created an Caret for '"+c+"'! +++")}function f(a){a=a.getMemberId();var b=d.getSelectionView(k),c=d.getSelectionView(gui.ShadowCursor.ShadowCursorMemberId),e=p.getCaret(k);a===k?(c.hide(),b&&b.show(),e&&e.show()):a===gui.ShadowCursor.ShadowCursorMemberId&&(c.show(),b&&b.hide(),e&&e.hide())}function c(a){d.removeSelectionView(a)}function a(a){var c=a.paragraphElement,d=a.memberId;a=a.timeStamp;
var e,f="",g=c.getElementsByTagNameNS(l,"editinfo").item(0);g?(f=g.getAttributeNS(l,"id"),e=s[f]):(f=Math.random().toString(),e=new ops.EditInfo(c,b.getOdtDocument()),e=new gui.EditInfoMarker(e,t),g=c.getElementsByTagNameNS(l,"editinfo").item(0),g.setAttributeNS(l,"id",f),s[f]=e);e.addEdit(d,new Date(a))}var e,l="urn:webodf:names:editinfo",s={},t=void 0!==g.editInfoMarkersInitiallyVisible?Boolean(g.editInfoMarkersInitiallyVisible):!0,y=void 0!==g.caretAvatarsInitiallyVisible?Boolean(g.caretAvatarsInitiallyVisible):
!0,B=void 0!==g.caretBlinksOnRangeSelect?Boolean(g.caretBlinksOnRangeSelect):!0;this.showEditInfoMarkers=function(){t||(t=!0,n(t))};this.hideEditInfoMarkers=function(){t&&(t=!1,n(t))};this.showCaretAvatars=function(){y||(y=!0,q(y))};this.hideCaretAvatars=function(){y&&(y=!1,q(y))};this.getSession=function(){return b};this.getCaret=function(a){return p.getCaret(a)};this.destroy=function(g){var h=b.getOdtDocument(),l=Object.keys(s).map(function(a){return s[a]});h.unsubscribe(ops.Document.signalMemberAdded,
r);h.unsubscribe(ops.Document.signalMemberUpdated,r);h.unsubscribe(ops.Document.signalCursorAdded,m);h.unsubscribe(ops.Document.signalCursorRemoved,c);h.unsubscribe(ops.OdtDocument.signalParagraphChanged,a);h.unsubscribe(ops.Document.signalCursorMoved,f);h.unsubscribe(ops.OdtDocument.signalParagraphChanged,d.rerenderSelectionViews);h.unsubscribe(ops.OdtDocument.signalTableAdded,d.rerenderSelectionViews);h.unsubscribe(ops.OdtDocument.signalParagraphStyleModified,d.rerenderSelectionViews);e.parentNode.removeChild(e);
(function x(a,b){b?g(b):a<l.length?l[a].destroy(function(b){x(a+1,b)}):g()})(0,void 0)};(function(){var g=b.getOdtDocument(),h=document.getElementsByTagName("head").item(0);g.subscribe(ops.Document.signalMemberAdded,r);g.subscribe(ops.Document.signalMemberUpdated,r);g.subscribe(ops.Document.signalCursorAdded,m);g.subscribe(ops.Document.signalCursorRemoved,c);g.subscribe(ops.OdtDocument.signalParagraphChanged,a);g.subscribe(ops.Document.signalCursorMoved,f);g.subscribe(ops.OdtDocument.signalParagraphChanged,
d.rerenderSelectionViews);g.subscribe(ops.OdtDocument.signalTableAdded,d.rerenderSelectionViews);g.subscribe(ops.OdtDocument.signalParagraphStyleModified,d.rerenderSelectionViews);e=document.createElementNS(h.namespaceURI,"style");e.type="text/css";e.media="screen, print, handheld, projection";e.appendChild(document.createTextNode("@namespace editinfo url(urn:webodf:names:editinfo);"));e.appendChild(document.createTextNode("@namespace dc url(http://purl.org/dc/elements/1.1/);"));h.appendChild(e)})()}})();
// Input 103
gui.SvgSelectionView=function(g){function k(){var b=a.getRootNode();e!==b&&(e=b,l=e.parentNode.parentNode.parentNode,l.appendChild(y),y.setAttribute("class","selectionOverlay"),y.appendChild(B))}function b(b){var c=v.getBoundingClientRect(l),d=a.getCanvas().getZoomLevel(),e={};e.top=v.adaptRangeDifferenceToZoomLevel(b.top-c.top,d);e.left=v.adaptRangeDifferenceToZoomLevel(b.left-c.left,d);e.bottom=v.adaptRangeDifferenceToZoomLevel(b.bottom-c.top,d);e.right=v.adaptRangeDifferenceToZoomLevel(b.right-
c.left,d);e.width=v.adaptRangeDifferenceToZoomLevel(b.width,d);e.height=v.adaptRangeDifferenceToZoomLevel(b.height,d);return e}function p(a){a=a.getBoundingClientRect();return Boolean(a&&0!==a.height)}function d(a){var b=D.getTextElements(a,!0,!1),c=a.cloneRange(),d=a.cloneRange();a=a.cloneRange();if(!b.length)return null;var e;a:{e=0;var f=b[e],g=c.startContainer===f?c.startOffset:0,h=g;c.setStart(f,g);for(c.setEnd(f,h);!p(c);){if(f.nodeType===Node.ELEMENT_NODE&&h<f.childNodes.length)h=f.childNodes.length;
else if(f.nodeType===Node.TEXT_NODE&&h<f.length)h+=1;else if(b[e])f=b[e],e+=1,g=h=0;else{e=!1;break a}c.setStart(f,g);c.setEnd(f,h)}e=!0}if(!e)return null;a:{e=b.length-1;f=b[e];h=g=d.endContainer===f?d.endOffset:f.nodeType===Node.TEXT_NODE?f.length:f.childNodes.length;d.setStart(f,g);for(d.setEnd(f,h);!p(d);){if(f.nodeType===Node.ELEMENT_NODE&&0<g)g=0;else if(f.nodeType===Node.TEXT_NODE&&0<g)g-=1;else if(b[e])f=b[e],e-=1,g=h=f.length||f.childNodes.length;else{b=!1;break a}d.setStart(f,g);d.setEnd(f,
h)}b=!0}if(!b)return null;a.setStart(c.startContainer,c.startOffset);a.setEnd(d.endContainer,d.endOffset);return{firstRange:c,lastRange:d,fillerRange:a}}function h(a,b){var c={};c.top=Math.min(a.top,b.top);c.left=Math.min(a.left,b.left);c.right=Math.max(a.right,b.right);c.bottom=Math.max(a.bottom,b.bottom);c.width=c.right-c.left;c.height=c.bottom-c.top;return c}function n(a,b){b&&0<b.width&&0<b.height&&(a=a?h(a,b):b);return a}function q(b){function c(a){w.setUnfilteredPosition(a,0);return u.acceptNode(a)===
x&&t.acceptPosition(w)===x?x:U}function d(a){var b=null;c(a)===x&&(b=v.getBoundingClientRect(a));return b}var e=b.commonAncestorContainer,f=b.startContainer,g=b.endContainer,h=b.startOffset,l=b.endOffset,k,m,p=null,q,r=s.createRange(),t,u=new odf.OdfNodeFilter,y;if(f===e||g===e)return r=b.cloneRange(),p=r.getBoundingClientRect(),r.detach(),p;for(b=f;b.parentNode!==e;)b=b.parentNode;for(m=g;m.parentNode!==e;)m=m.parentNode;t=a.createRootFilter(f);for(e=b.nextSibling;e&&e!==m;)q=d(e),p=n(p,q),e=e.nextSibling;
if(D.isParagraph(b))p=n(p,v.getBoundingClientRect(b));else if(b.nodeType===Node.TEXT_NODE)e=b,r.setStart(e,h),r.setEnd(e,e===m?l:e.length),q=r.getBoundingClientRect(),p=n(p,q);else for(y=s.createTreeWalker(b,NodeFilter.SHOW_TEXT,c,!1),e=y.currentNode=f;e&&e!==g;)r.setStart(e,h),r.setEnd(e,e.length),q=r.getBoundingClientRect(),p=n(p,q),k=e,h=0,e=y.nextNode();k||(k=f);if(D.isParagraph(m))p=n(p,v.getBoundingClientRect(m));else if(m.nodeType===Node.TEXT_NODE)e=m,r.setStart(e,e===b?h:0),r.setEnd(e,l),
q=r.getBoundingClientRect(),p=n(p,q);else for(y=s.createTreeWalker(m,NodeFilter.SHOW_TEXT,c,!1),e=y.currentNode=g;e&&e!==k;)if(r.setStart(e,0),r.setEnd(e,l),q=r.getBoundingClientRect(),p=n(p,q),e=y.previousNode())l=e.length;return p}function r(a,b){var c=a.getBoundingClientRect(),d={width:0};d.top=c.top;d.bottom=c.bottom;d.height=c.height;d.left=d.right=b?c.right:c.left;return d}function m(){var a=g.getSelectedRange(),c;if(c=u&&g.getSelectionType()===ops.OdtCursor.RangeSelection&&!a.collapsed){var a=
d(a),e,f,l,m,n,p,s,t;if(a){c=a.firstRange;e=a.lastRange;f=a.fillerRange;l=b(r(c,!1));n=b(r(e,!0));m=(m=q(f))?b(m):h(l,n);p=m.left;m=l.left+Math.max(0,m.width-(l.left-m.left));s=Math.min(l.top,n.top);t=n.top+n.height;l=[{x:l.left,y:s+l.height},{x:l.left,y:s},{x:m,y:s},{x:m,y:t-n.height},{x:n.right,y:t-n.height},{x:n.right,y:t},{x:p,y:t},{x:p,y:s+l.height},{x:l.left,y:s+l.height}];n="";for(p=0;p<l.length;p+=1)n+=l[p].x+","+l[p].y+" ";B.setAttribute("points",n);c.detach();e.detach();f.detach()}c=Boolean(a)}c?
(y.style.display="block",k()):y.style.display="none"}function f(a){u&&a===g&&E.trigger()}function c(a){l.removeChild(y);g.getDocument().unsubscribe(ops.Document.signalCursorMoved,f);a()}var a=g.getDocument(),e,l,s=a.getDOMDocument(),t=new core.Async,y=s.createElementNS("http://www.w3.org/2000/svg","svg"),B=s.createElementNS("http://www.w3.org/2000/svg","polygon"),D=new odf.OdfUtils,v=new core.DomUtils,u=!0,w=gui.SelectionMover.createPositionIterator(a.getRootNode()),x=NodeFilter.FILTER_ACCEPT,U=NodeFilter.FILTER_REJECT,
E;this.rerender=function(){u&&E.trigger()};this.show=function(){u=!0;E.trigger()};this.hide=function(){u=!1;E.trigger()};this.destroy=function(a){t.destroyAll([E.destroy,c],a)};(function(){var a=g.getMemberId();E=new core.ScheduledTask(m,0);k();y.setAttributeNS("urn:webodf:names:editinfo","editinfo:memberid",a);g.getDocument().subscribe(ops.Document.signalCursorMoved,f)})()};
// Input 104
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.UndoStateRules=function(){function g(b,g){var k=b.length;this.previous=function(){for(k-=1;0<=k;k-=1)if(g(b[k]))return b[k];return null}}function k(b){b=b.spec();var g;b.hasOwnProperty("position")&&(g=b.position);return g}function b(b){return b.isEdit}function p(b,g,n){if(!n)return n=k(b)-k(g),0===n||1===Math.abs(n);b=k(b);g=k(g);n=k(n);return b-g===g-n}this.isEditOperation=b;this.isPartOfOperationSet=function(d,h){var k=void 0!==d.group,q;if(!d.isEdit||0===h.length)return!0;q=h[h.length-1];if(k&&
d.group===q.group)return!0;a:switch(d.spec().optype){case "RemoveText":case "InsertText":q=!0;break a;default:q=!1}if(q&&h.some(b)){if(k){var r;k=d.spec().optype;q=new g(h,b);var m=q.previous(),f=null,c,a;runtime.assert(Boolean(m),"No edit operations found in state");a=m.group;runtime.assert(void 0!==a,"Operation has no group");for(c=1;m&&m.group===a;){if(k===m.spec().optype){r=m;break}m=q.previous()}if(r){for(m=q.previous();m;){if(m.group!==a){if(2===c)break;a=m.group;c+=1}if(k===m.spec().optype){f=
m;break}m=q.previous()}r=p(d,r,f)}else r=!1;return r}r=d.spec().optype;k=new g(h,b);q=k.previous();runtime.assert(Boolean(q),"No edit operations found in state");r=r===q.spec().optype?p(d,q,k.previous()):!1;return r}return!1}};
// Input 105
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
gui.TrivialUndoManager=function(g){function k(a){0<a.length&&(v=!0,e(a),v=!1)}function b(){B.emit(gui.UndoManager.signalUndoStackChanged,{undoAvailable:r.hasUndoStates(),redoAvailable:r.hasRedoStates()})}function p(){s!==a&&s!==t[t.length-1]&&t.push(s)}function d(a){var b=a.previousSibling||a.nextSibling;a.parentNode.removeChild(a);f.normalizeTextNodes(b)}function h(a){return Object.keys(a).map(function(b){return a[b]})}function n(a){function b(a){var g=a.spec();if(e[g.memberid])switch(g.optype){case "AddCursor":c[g.memberid]||
(c[g.memberid]=a,delete e[g.memberid],f-=1);break;case "MoveCursor":d[g.memberid]||(d[g.memberid]=a)}}var c={},d={},e={},f,g=a.pop();l.getMemberIds().forEach(function(a){e[a]=!0});for(f=Object.keys(e).length;g&&0<f;)g.reverse(),g.forEach(b),g=a.pop();return h(c).concat(h(d))}function q(){var e=c=l.cloneDocumentElement();f.getElementsByTagNameNS(e,m,"cursor").forEach(d);f.getElementsByTagNameNS(e,m,"anchor").forEach(d);p();s=a=n([a].concat(t));t.length=0;y.length=0;b()}var r=this,m="urn:webodf:names:cursor",
f=new core.DomUtils,c,a=[],e,l,s=[],t=[],y=[],B=new core.EventNotifier([gui.UndoManager.signalUndoStackChanged,gui.UndoManager.signalUndoStateCreated,gui.UndoManager.signalUndoStateModified,gui.TrivialUndoManager.signalDocumentRootReplaced]),D=g||new gui.UndoStateRules,v=!1;this.subscribe=function(a,b){B.subscribe(a,b)};this.unsubscribe=function(a,b){B.unsubscribe(a,b)};this.hasUndoStates=function(){return 0<t.length};this.hasRedoStates=function(){return 0<y.length};this.setDocument=function(a){l=
a};this.purgeInitialState=function(){t.length=0;y.length=0;a.length=0;s.length=0;c=null;b()};this.setInitialState=q;this.initialize=function(){c||q()};this.setPlaybackFunction=function(a){e=a};this.onOperationExecuted=function(c){v||(D.isEditOperation(c)&&(s===a||0<y.length)||!D.isPartOfOperationSet(c,s)?(y.length=0,p(),s=[c],t.push(s),B.emit(gui.UndoManager.signalUndoStateCreated,{operations:s}),b()):(s.push(c),B.emit(gui.UndoManager.signalUndoStateModified,{operations:s})))};this.moveForward=function(a){for(var c=
0,d;a&&y.length;)d=y.pop(),t.push(d),k(d),a-=1,c+=1;c&&(s=t[t.length-1],b());return c};this.moveBackward=function(d){for(var e=0;d&&t.length;)y.push(t.pop()),d-=1,e+=1;e&&(l.setDocumentElement(c.cloneNode(!0)),B.emit(gui.TrivialUndoManager.signalDocumentRootReplaced,{}),l.getMemberIds().forEach(function(a){l.removeCursor(a)}),k(a),t.forEach(k),s=t[t.length-1]||a,b());return e}};gui.TrivialUndoManager.signalDocumentRootReplaced="documentRootReplaced";(function(){return gui.TrivialUndoManager})();
// Input 106
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OperationTransformMatrix=function(){function g(b){b.position+=b.length;b.length*=-1}function k(b){var a=0>b.length;a&&g(b);return a}function b(b,a){function d(e){b[e]===a&&f.push(e)}var f=[];b&&["style:parent-style-name","style:next-style-name"].forEach(d);return f}function p(b,a){function d(e){b[e]===a&&delete b[e]}b&&["style:parent-style-name","style:next-style-name"].forEach(d)}function d(b){var a={};Object.keys(b).forEach(function(e){a[e]="object"===typeof b[e]?d(b[e]):b[e]});return a}function h(b,
a,d,f){var g,h=!1,k=!1,m,n=[];f&&f.attributes&&(n=f.attributes.split(","));b&&(d||0<n.length)&&Object.keys(b).forEach(function(a){var f=b[a],g;"object"!==typeof f&&(d&&(g=d[a]),void 0!==g?(delete b[a],k=!0,g===f&&(delete d[a],h=!0)):-1!==n.indexOf(a)&&(delete b[a],k=!0))});if(a&&a.attributes&&(d||0<n.length)){m=a.attributes.split(",");for(f=0;f<m.length;f+=1)if(g=m[f],d&&void 0!==d[g]||n&&-1!==n.indexOf(g))m.splice(f,1),f-=1,k=!0;0<m.length?a.attributes=m.join(","):delete a.attributes}return{majorChanged:h,
minorChanged:k}}function n(b){for(var a in b)if(b.hasOwnProperty(a))return!0;return!1}function q(b){for(var a in b)if(b.hasOwnProperty(a)&&("attributes"!==a||0<b.attributes.length))return!0;return!1}function r(b,a,d,f,g){var k=b?b[g]:null,m=a?a[g]:null,p=d?d[g]:null,r=f?f[g]:null,v;v=h(k,m,p,r);k&&!n(k)&&delete b[g];m&&!q(m)&&delete a[g];p&&!n(p)&&delete d[g];r&&!q(r)&&delete f[g];return v}function m(b,a){return{opSpecsA:[b],opSpecsB:[a]}}var f;f={AddCursor:{AddCursor:m,AddMember:m,AddStyle:m,ApplyDirectStyling:m,
InsertText:m,MoveCursor:m,RemoveCursor:m,RemoveMember:m,RemoveStyle:m,RemoveText:m,SetParagraphStyle:m,SplitParagraph:m,UpdateMember:m,UpdateMetadata:m,UpdateParagraphStyle:m},AddMember:{AddStyle:m,InsertText:m,MoveCursor:m,RemoveCursor:m,RemoveStyle:m,RemoveText:m,SetParagraphStyle:m,SplitParagraph:m,UpdateMetadata:m,UpdateParagraphStyle:m},AddStyle:{AddStyle:m,ApplyDirectStyling:m,InsertText:m,MoveCursor:m,RemoveCursor:m,RemoveMember:m,RemoveStyle:function(c,a){var d,f=[c],g=[a];c.styleFamily===
a.styleFamily&&(d=b(c.setProperties,a.styleName),0<d.length&&(d={optype:"UpdateParagraphStyle",memberid:a.memberid,timestamp:a.timestamp,styleName:c.styleName,removedProperties:{attributes:d.join(",")}},g.unshift(d)),p(c.setProperties,a.styleName));return{opSpecsA:f,opSpecsB:g}},RemoveText:m,SetParagraphStyle:m,SplitParagraph:m,UpdateMember:m,UpdateMetadata:m,UpdateParagraphStyle:m},ApplyDirectStyling:{ApplyDirectStyling:function(b,a,e){var f,g,h,k,m,p,q,u;k=[b];h=[a];if(!(b.position+b.length<=a.position||
b.position>=a.position+a.length)){f=e?b:a;g=e?a:b;if(b.position!==a.position||b.length!==a.length)p=d(f),q=d(g);a=r(g.setProperties,null,f.setProperties,null,"style:text-properties");if(a.majorChanged||a.minorChanged)h=[],b=[],k=f.position+f.length,m=g.position+g.length,g.position<f.position?a.minorChanged&&(u=d(q),u.length=f.position-g.position,b.push(u),g.position=f.position,g.length=m-g.position):f.position<g.position&&a.majorChanged&&(u=d(p),u.length=g.position-f.position,h.push(u),f.position=
g.position,f.length=k-f.position),m>k?a.minorChanged&&(p=q,p.position=k,p.length=m-k,b.push(p),g.length=k-g.position):k>m&&a.majorChanged&&(p.position=m,p.length=k-m,h.push(p),f.length=m-f.position),f.setProperties&&n(f.setProperties)&&h.push(f),g.setProperties&&n(g.setProperties)&&b.push(g),e?(k=h,h=b):k=b}return{opSpecsA:k,opSpecsB:h}},InsertText:function(b,a){a.position<=b.position?b.position+=a.text.length:a.position<=b.position+b.length&&(b.length+=a.text.length);return{opSpecsA:[b],opSpecsB:[a]}},
MoveCursor:m,RemoveCursor:m,RemoveStyle:m,RemoveText:function(b,a){var d=b.position+b.length,f=a.position+a.length,g=[b],h=[a];f<=b.position?b.position-=a.length:a.position<d&&(b.position<a.position?b.length=f<d?b.length-a.length:a.position-b.position:(b.position=a.position,f<d?b.length=d-f:g=[]));return{opSpecsA:g,opSpecsB:h}},SetParagraphStyle:m,SplitParagraph:function(b,a){a.position<b.position?b.position+=1:a.position<b.position+b.length&&(b.length+=1);return{opSpecsA:[b],opSpecsB:[a]}},UpdateMetadata:m,
UpdateParagraphStyle:m},InsertText:{InsertText:function(b,a,d){b.position<a.position?a.position+=b.text.length:b.position>a.position?b.position+=a.text.length:d?a.position+=b.text.length:b.position+=a.text.length;return{opSpecsA:[b],opSpecsB:[a]}},MoveCursor:function(b,a){var d=k(a);b.position<a.position?a.position+=b.text.length:b.position<a.position+a.length&&(a.length+=b.text.length);d&&g(a);return{opSpecsA:[b],opSpecsB:[a]}},RemoveCursor:m,RemoveMember:m,RemoveStyle:m,RemoveText:function(b,a){var d;
d=a.position+a.length;var f=[b],g=[a];d<=b.position?b.position-=a.length:b.position<=a.position?a.position+=b.text.length:(a.length=b.position-a.position,d={optype:"RemoveText",memberid:a.memberid,timestamp:a.timestamp,position:b.position+b.text.length,length:d-b.position},g.unshift(d),b.position=a.position);return{opSpecsA:f,opSpecsB:g}},SplitParagraph:function(b,a,d){if(b.position<a.position)a.position+=b.text.length;else if(b.position>a.position)b.position+=1;else return d?a.position+=b.text.length:
b.position+=1,null;return{opSpecsA:[b],opSpecsB:[a]}},UpdateMember:m,UpdateMetadata:m,UpdateParagraphStyle:m},MoveCursor:{MoveCursor:m,RemoveCursor:function(b,a){return{opSpecsA:b.memberid===a.memberid?[]:[b],opSpecsB:[a]}},RemoveMember:m,RemoveStyle:m,RemoveText:function(b,a){var d=k(b),f=b.position+b.length,h=a.position+a.length;h<=b.position?b.position-=a.length:a.position<f&&(b.position<a.position?b.length=h<f?b.length-a.length:a.position-b.position:(b.position=a.position,b.length=h<f?f-h:0));
d&&g(b);return{opSpecsA:[b],opSpecsB:[a]}},SetParagraphStyle:m,SplitParagraph:function(b,a){var d=k(b);a.position<b.position?b.position+=1:a.position<b.position+b.length&&(b.length+=1);d&&g(b);return{opSpecsA:[b],opSpecsB:[a]}},UpdateMember:m,UpdateMetadata:m,UpdateParagraphStyle:m},RemoveCursor:{RemoveCursor:function(b,a){var d=b.memberid===a.memberid;return{opSpecsA:d?[]:[b],opSpecsB:d?[]:[a]}},RemoveMember:m,RemoveStyle:m,RemoveText:m,SetParagraphStyle:m,SplitParagraph:m,UpdateMember:m,UpdateMetadata:m,
UpdateParagraphStyle:m},RemoveMember:{RemoveStyle:m,RemoveText:m,SetParagraphStyle:m,SplitParagraph:m,UpdateMetadata:m,UpdateParagraphStyle:m},RemoveStyle:{RemoveStyle:function(b,a){var d=b.styleName===a.styleName&&b.styleFamily===a.styleFamily;return{opSpecsA:d?[]:[b],opSpecsB:d?[]:[a]}},RemoveText:m,SetParagraphStyle:function(b,a){var d,f=[b],g=[a];"paragraph"===b.styleFamily&&b.styleName===a.styleName&&(d={optype:"SetParagraphStyle",memberid:b.memberid,timestamp:b.timestamp,position:a.position,
styleName:""},f.unshift(d),a.styleName="");return{opSpecsA:f,opSpecsB:g}},SplitParagraph:m,UpdateMember:m,UpdateMetadata:m,UpdateParagraphStyle:function(c,a){var d,f=[c],g=[a];"paragraph"===c.styleFamily&&(d=b(a.setProperties,c.styleName),0<d.length&&(d={optype:"UpdateParagraphStyle",memberid:c.memberid,timestamp:c.timestamp,styleName:a.styleName,removedProperties:{attributes:d.join(",")}},f.unshift(d)),c.styleName===a.styleName?g=[]:p(a.setProperties,c.styleName));return{opSpecsA:f,opSpecsB:g}}},
RemoveText:{RemoveText:function(b,a){var d=b.position+b.length,f=a.position+a.length,g=[b],h=[a];f<=b.position?b.position-=a.length:d<=a.position?a.position-=b.length:a.position<d&&(b.position<a.position?(b.length=f<d?b.length-a.length:a.position-b.position,d<f?(a.position=b.position,a.length=f-d):h=[]):(d<f?a.length-=b.length:a.position<b.position?a.length=b.position-a.position:h=[],f<d?(b.position=a.position,b.length=d-f):g=[]));return{opSpecsA:g,opSpecsB:h}},SplitParagraph:function(b,a){var d=
b.position+b.length,f=[b],g=[a];a.position<=b.position?b.position+=1:a.position<d&&(b.length=a.position-b.position,d={optype:"RemoveText",memberid:b.memberid,timestamp:b.timestamp,position:a.position+1,length:d-a.position},f.unshift(d));b.position+b.length<=a.position?a.position-=b.length:b.position<a.position&&(a.position=b.position);return{opSpecsA:f,opSpecsB:g}},UpdateMember:m,UpdateMetadata:m,UpdateParagraphStyle:m},SetParagraphStyle:{UpdateMember:m,UpdateMetadata:m,UpdateParagraphStyle:m},SplitParagraph:{SplitParagraph:function(b,
a,d){b.position<a.position?a.position+=1:b.position>a.position?b.position+=1:b.position===a.position&&(d?a.position+=1:b.position+=1);return{opSpecsA:[b],opSpecsB:[a]}},UpdateMember:m,UpdateMetadata:m,UpdateParagraphStyle:m},UpdateMember:{UpdateMetadata:m,UpdateParagraphStyle:m},UpdateMetadata:{UpdateMetadata:function(b,a,d){var f,g=[b],k=[a];f=d?b:a;b=d?a:b;h(b.setProperties||null,b.removedProperties||null,f.setProperties||null,f.removedProperties||null);f.setProperties&&n(f.setProperties)||f.removedProperties&&
q(f.removedProperties)||(d?g=[]:k=[]);b.setProperties&&n(b.setProperties)||b.removedProperties&&q(b.removedProperties)||(d?k=[]:g=[]);return{opSpecsA:g,opSpecsB:k}},UpdateParagraphStyle:m},UpdateParagraphStyle:{UpdateParagraphStyle:function(b,a,d){var f,g=[b],k=[a];b.styleName===a.styleName&&(f=d?b:a,b=d?a:b,r(b.setProperties,b.removedProperties,f.setProperties,f.removedProperties,"style:paragraph-properties"),r(b.setProperties,b.removedProperties,f.setProperties,f.removedProperties,"style:text-properties"),
h(b.setProperties||null,b.removedProperties||null,f.setProperties||null,f.removedProperties||null),f.setProperties&&n(f.setProperties)||f.removedProperties&&q(f.removedProperties)||(d?g=[]:k=[]),b.setProperties&&n(b.setProperties)||b.removedProperties&&q(b.removedProperties)||(d?k=[]:g=[]));return{opSpecsA:g,opSpecsB:k}}}};this.passUnchanged=m;this.extendTransformations=function(b){Object.keys(b).forEach(function(a){var d=b[a],g,h=f.hasOwnProperty(a);runtime.log((h?"Extending":"Adding")+" map for optypeA: "+
a);h||(f[a]={});g=f[a];Object.keys(d).forEach(function(b){var c=g.hasOwnProperty(b);runtime.assert(a<=b,"Wrong order:"+a+", "+b);runtime.log("  "+(c?"Overwriting":"Adding")+" entry for optypeB: "+b);g[b]=d[b]})})};this.transformOpspecVsOpspec=function(b,a){var d=b.optype<=a.optype,g;runtime.log("Crosstransforming:");runtime.log(runtime.toJson(b));runtime.log(runtime.toJson(a));d||(g=b,b=a,a=g);(g=(g=f[b.optype])&&g[a.optype])?(g=g(b,a,!d),d||null===g||(g={opSpecsA:g.opSpecsB,opSpecsB:g.opSpecsA})):
g=null;runtime.log("result:");g?(runtime.log(runtime.toJson(g.opSpecsA)),runtime.log(runtime.toJson(g.opSpecsB))):runtime.log("null");return g}};
// Input 107
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 This file is part of WebODF.

 WebODF is free software: you can redistribute it and/or modify it
 under the terms of the GNU Affero General Public License (GNU AGPL)
 as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.

 WebODF is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU Affero General Public License for more details.

 You should have received a copy of the GNU Affero General Public License
 along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 @licend

 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.OperationTransformer=function(){function g(d){var g=[];d.forEach(function(d){g.push(b.create(d))});return g}function k(b,g){for(var n,q,r=[],m=[];0<b.length&&g;){n=b.shift();n=p.transformOpspecVsOpspec(n,g);if(!n)return null;r=r.concat(n.opSpecsA);if(0===n.opSpecsB.length){r=r.concat(b);g=null;break}for(;1<n.opSpecsB.length;){q=k(b,n.opSpecsB.shift());if(!q)return null;m=m.concat(q.opSpecsB);b=q.opSpecsA}g=n.opSpecsB.pop()}g&&m.push(g);return{opSpecsA:r,opSpecsB:m}}var b,p=new ops.OperationTransformMatrix;
this.setOperationFactory=function(d){b=d};this.getOperationTransformMatrix=function(){return p};this.transform=function(b,h){for(var n,p=[];0<h.length;){n=k(b,h.shift());if(!n)return null;b=n.opSpecsA;p=p.concat(n.opSpecsB)}return{opsA:g(b),opsB:g(p)}}};
// Input 108
/*

 Copyright (C) 2013 KO GmbH <copyright@kogmbh.com>

 @licstart
 The JavaScript code in this page is free software: you can redistribute it
 and/or modify it under the terms of the GNU Affero General Public License
 (GNU AGPL) as published by the Free Software Foundation, either version 3 of
 the License, or (at your option) any later version.  The code is distributed
 WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 FITNESS FOR A PARTICULAR PURPOSE.  See the GNU AGPL for more details.

 You should have received a copy of the GNU Affero General Public License
 along with this code.  If not, see <http://www.gnu.org/licenses/>.

 As additional permission under GNU AGPL version 3 section 7, you
 may distribute non-source (e.g., minimized or compacted) forms of
 that code without the copy of the GNU GPL normally required by
 section 4, provided you include this license notice and a URL
 through which recipients can access the Corresponding Source.

 As a special exception to the AGPL, any HTML file which merely makes function
 calls to this code, and for that purpose includes it by reference shall be
 deemed a separate work for copyright law purposes. In addition, the copyright
 holders of this code give you permission to combine this code with free
 software libraries that are released under the GNU LGPL. You may copy and
 distribute such a system following the terms of the GNU AGPL for this code
 and the LGPL for the libraries. If you modify this code, you may extend this
 exception to your version of the code, but you are not obligated to do so.
 If you do not wish to do so, delete this exception statement from your
 version.

 This license applies to this entire compilation.
 @licend
 @source: http://www.webodf.org/
 @source: https://github.com/kogmbh/WebODF/
*/
ops.Server=function(){};ops.Server.prototype.connect=function(g,k){};ops.Server.prototype.networkStatus=function(){};ops.Server.prototype.login=function(g,k,b,p){};ops.Server.prototype.joinSession=function(g,k,b,p){};ops.Server.prototype.leaveSession=function(g,k,b,p){};ops.Server.prototype.getGenesisUrl=function(g){};
// Input 109
var webodf_css='@namespace draw url(urn:oasis:names:tc:opendocument:xmlns:drawing:1.0);\n@namespace fo url(urn:oasis:names:tc:opendocument:xmlns:xsl-fo-compatible:1.0);\n@namespace office url(urn:oasis:names:tc:opendocument:xmlns:office:1.0);\n@namespace presentation url(urn:oasis:names:tc:opendocument:xmlns:presentation:1.0);\n@namespace style url(urn:oasis:names:tc:opendocument:xmlns:style:1.0);\n@namespace svg url(urn:oasis:names:tc:opendocument:xmlns:svg-compatible:1.0);\n@namespace table url(urn:oasis:names:tc:opendocument:xmlns:table:1.0);\n@namespace text url(urn:oasis:names:tc:opendocument:xmlns:text:1.0);\n@namespace webodfhelper url(urn:webodf:names:helper);\n@namespace cursor url(urn:webodf:names:cursor);\n@namespace editinfo url(urn:webodf:names:editinfo);\n@namespace annotation url(urn:webodf:names:annotation);\n@namespace dc url(http://purl.org/dc/elements/1.1/);\n@namespace svgns url(http://www.w3.org/2000/svg);\n\noffice|document > *, office|document-content > * {\n  display: none;\n}\noffice|body, office|document {\n  display: inline-block;\n  position: relative;\n}\n\ntext|p, text|h {\n  display: block;\n  padding: 0;\n  margin: 0;\n  line-height: normal;\n  position: relative;\n  min-height: 1.3em; /* prevent empty paragraphs and headings from collapsing if they are empty */\n}\n*[webodfhelper|containsparagraphanchor] {\n  position: relative;\n}\ntext|s {\n    white-space: pre;\n}\ntext|tab {\n  display: inline;\n  white-space: pre;\n}\ntext|tracked-changes {\n  /*Consumers that do not support change tracking, should ignore changes.*/\n  display: none;\n}\noffice|binary-data {\n  display: none;\n}\noffice|text {\n  display: block;\n  text-align: left;\n  overflow: visible;\n  word-wrap: break-word;\n  position: relative;\n}\n\noffice|text::selection {\n  /** Let\'s not draw selection highlight that overflows into the office|text\n   * node when selecting content across several paragraphs\n   */\n  background: transparent;\n}\n\noffice|document *::selection {\n  background: transparent;\n}\noffice|document *::-moz-selection {\n  background: transparent;\n}\n\noffice|text * draw|text-box {\n/** only for text documents */\n    display: block;\n    border: 1px solid #d3d3d3;\n}\ndraw|frame {\n  /** make sure frames are above the main body. */\n  z-index: 1;\n}\noffice|spreadsheet {\n  display: block;\n  border-collapse: collapse;\n  empty-cells: show;\n  font-family: sans-serif;\n  font-size: 10pt;\n  text-align: left;\n  page-break-inside: avoid;\n  overflow: hidden;\n}\noffice|presentation {\n  display: inline-block;\n  text-align: left;\n}\n#shadowContent {\n  display: inline-block;\n  text-align: left;\n}\ndraw|page {\n  display: block;\n  position: relative;\n  overflow: hidden;\n}\npresentation|notes, presentation|footer-decl, presentation|date-time-decl {\n    display: none;\n}\n@media print {\n  draw|page {\n    border: 1pt solid black;\n    page-break-inside: avoid;\n  }\n  presentation|notes {\n    /*TODO*/\n  }\n}\noffice|spreadsheet text|p {\n  border: 0px;\n  padding: 1px;\n  margin: 0px;\n}\noffice|spreadsheet table|table {\n  margin: 3px;\n}\noffice|spreadsheet table|table:after {\n  /* show sheet name the end of the sheet */\n  /*content: attr(table|name);*/ /* gives parsing error in opera */\n}\noffice|spreadsheet table|table-row {\n  counter-increment: row;\n}\noffice|spreadsheet table|table-row:before {\n  width: 3em;\n  background: #cccccc;\n  border: 1px solid black;\n  text-align: center;\n  content: counter(row);\n  display: table-cell;\n}\noffice|spreadsheet table|table-cell {\n  border: 1px solid #cccccc;\n}\ntable|table {\n  display: table;\n}\ndraw|frame table|table {\n  width: 100%;\n  height: 100%;\n  background: white;\n}\ntable|table-header-rows {\n  display: table-header-group;\n}\ntable|table-row {\n  display: table-row;\n}\ntable|table-column {\n  display: table-column;\n}\ntable|table-cell {\n  width: 0.889in;\n  display: table-cell;\n  word-break: break-all; /* prevent long words from extending out the table cell */\n}\ndraw|frame {\n  display: block;\n}\ndraw|image {\n  display: block;\n  width: 100%;\n  height: 100%;\n  top: 0px;\n  left: 0px;\n  background-repeat: no-repeat;\n  background-size: 100% 100%;\n  -moz-background-size: 100% 100%;\n}\n/* only show the first image in frame */\ndraw|frame > draw|image:nth-of-type(n+2) {\n  display: none;\n}\ntext|list:before {\n    display: none;\n    content:"";\n}\ntext|list {\n    counter-reset: list;\n}\ntext|list-item {\n    display: block;\n}\ntext|number {\n    display:none;\n}\n\ntext|a {\n    color: blue;\n    text-decoration: underline;\n    cursor: pointer;\n}\noffice|text[webodfhelper|links="inactive"] text|a {\n    cursor: text;\n}\ntext|note-citation {\n    vertical-align: super;\n    font-size: smaller;\n}\ntext|note-body {\n    display: none;\n}\ntext|note:hover text|note-citation {\n    background: #dddddd;\n}\ntext|note:hover text|note-body {\n    display: block;\n    left:1em;\n    max-width: 80%;\n    position: absolute;\n    background: #ffffaa;\n}\ntext|bibliography-source { display: none; }\nsvg|title, svg|desc {\n    display: none;\n}\nvideo {\n    width: 100%;\n    height: 100%\n}\n\n/* below set up the cursor */\ncursor|cursor {\n    display: inline;\n    width: 0;\n    height: 1em;\n    /* making the position relative enables the avatar to use\n       the cursor as reference for its absolute position */\n    position: relative;\n    z-index: 1;\n    pointer-events: none;\n}\n\ncursor|cursor > .caret {\n    /* IMPORTANT: when changing these values ensure DEFAULT_CARET_TOP and DEFAULT_CARET_HEIGHT\n        in Caret.js remain in sync */\n    display: inline;\n    position: absolute;\n    top: 5%; /* push down the caret; 0px can do the job, 5% looks better, 10% is a bit over */\n    height: 1em;\n    border-left: 2px solid black;\n    outline: none;\n}\n\ncursor|cursor > .handle {\n    padding: 3px;\n    box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75);\n    border: none !important;\n    border-radius: 5px;\n    opacity: 0.3;\n}\n\ncursor|cursor > .handle > img {\n    border-radius: 5px;\n}\n\ncursor|cursor > .handle.active {\n    opacity: 0.8;\n}\n\ncursor|cursor > .handle:after {\n    content: \' \';\n    position: absolute;\n    width: 0px;\n    height: 0px;\n    border-style: solid;\n    border-width: 8.7px 5px 0 5px;\n    border-color: black transparent transparent transparent;\n\n    top: 100%;\n    left: 43%;\n}\n\n/** Input Method Editor input pane & behaviours */\n/* not within a cursor */\n#eventTrap {\n    height: auto;\n    display: block;\n    position: absolute;\n    width: 1px;\n    outline: none;\n    opacity: 0;\n    color: rgba(255, 255, 255, 0); /* hide the blinking caret by setting the colour to fully transparent */\n    overflow: hidden; /* The overflow visibility is used to hide and show characters being entered */\n}\n\n/* within a cursor */\ncursor|cursor > #composer {\n    text-decoration: underline;\n}\n\ncursor|cursor[cursor|composing="true"] > #composer {\n    display: inline-block;\n    height: auto;\n    width: auto;\n}\n\ncursor|cursor[cursor|composing="true"] {\n    display: inline-block;\n    width: auto;\n    height: inherit;\n}\n\ncursor|cursor[cursor|composing="true"] > .caret {\n    /* during composition, the caret should be pushed along by the composition text, inline with the text */\n    position: static;\n    /* as it is now part of an inline-block, it will no longer need correct to top or height values to align properly */\n    height: auto !important;\n    top: auto !important;\n}\n\neditinfo|editinfo {\n    /* Empty or invisible display:inline elements respond very badly to mouse selection.\n       Inline blocks are much more reliably selectable in Chrome & friends */\n    display: inline-block;\n}\n\n.editInfoMarker {\n    position: absolute;\n    width: 10px;\n    height: 100%;\n    left: -20px;\n    opacity: 0.8;\n    top: 0;\n    border-radius: 5px;\n    background-color: transparent;\n    box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75);\n}\n.editInfoMarker:hover {\n    box-shadow: 0px 0px 8px rgba(0, 0, 0, 1);\n}\n\n.editInfoHandle {\n    position: absolute;\n    background-color: black;\n    padding: 5px;\n    border-radius: 5px;\n    opacity: 0.8;\n    box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75);\n    bottom: 100%;\n    margin-bottom: 10px;\n    z-index: 3;\n    left: -25px;\n}\n.editInfoHandle:after {\n    content: \' \';\n    position: absolute;\n    width: 0px;\n    height: 0px;\n    border-style: solid;\n    border-width: 8.7px 5px 0 5px;\n    border-color: black transparent transparent transparent;\n\n    top: 100%;\n    left: 5px;\n}\n.editInfo {\n    font-family: sans-serif;\n    font-weight: normal;\n    font-style: normal;\n    text-decoration: none;\n    color: white;\n    width: 100%;\n    height: 12pt;\n}\n.editInfoColor {\n    float: left;\n    width: 10pt;\n    height: 10pt;\n    border: 1px solid white;\n}\n.editInfoAuthor {\n    float: left;\n    margin-left: 5pt;\n    font-size: 10pt;\n    text-align: left;\n    height: 12pt;\n    line-height: 12pt;\n}\n.editInfoTime {\n    float: right;\n    margin-left: 30pt;\n    font-size: 8pt;\n    font-style: italic;\n    color: yellow;\n    height: 12pt;\n    line-height: 12pt;\n}\n\n.annotationWrapper {\n    display: inline;\n    position: relative;\n}\n\n.annotationRemoveButton:before {\n    content: \'\u00d7\';\n    color: white;\n    padding: 5px;\n    line-height: 1em;\n}\n\n.annotationRemoveButton {\n    width: 20px;\n    height: 20px;\n    border-radius: 10px;\n    background-color: black;\n    box-shadow: 0px 0px 5px rgba(50, 50, 50, 0.75);\n    position: absolute;\n    top: -10px;\n    left: -10px;\n    z-index: 3;\n    text-align: center;\n    font-family: sans-serif;\n    font-style: normal;\n    font-weight: normal;\n    text-decoration: none;\n    font-size: 15px;\n}\n.annotationRemoveButton:hover {\n    cursor: pointer;\n    box-shadow: 0px 0px 5px rgba(0, 0, 0, 1);\n}\n\n.annotationNote {\n    width: 4cm;\n    position: absolute;\n    display: inline;\n    z-index: 10;\n}\n.annotationNote > office|annotation {\n    display: block;\n    text-align: left;\n}\n\n.annotationConnector {\n    position: absolute;\n    display: inline;\n    z-index: 2;\n    border-top: 1px dashed brown;\n}\n.annotationConnector.angular {\n    -moz-transform-origin: left top;\n    -webkit-transform-origin: left top;\n    -ms-transform-origin: left top;\n    transform-origin: left top;\n}\n.annotationConnector.horizontal {\n    left: 0;\n}\n.annotationConnector.horizontal:before {\n    content: \'\';\n    display: inline;\n    position: absolute;\n    width: 0px;\n    height: 0px;\n    border-style: solid;\n    border-width: 8.7px 5px 0 5px;\n    border-color: brown transparent transparent transparent;\n    top: -1px;\n    left: -5px;\n}\n\noffice|annotation {\n    width: 100%;\n    height: 100%;\n    display: none;\n    background: rgb(198, 238, 184);\n    background: -moz-linear-gradient(90deg, rgb(198, 238, 184) 30%, rgb(180, 196, 159) 100%);\n    background: -webkit-linear-gradient(90deg, rgb(198, 238, 184) 30%, rgb(180, 196, 159) 100%);\n    background: -o-linear-gradient(90deg, rgb(198, 238, 184) 30%, rgb(180, 196, 159) 100%);\n    background: -ms-linear-gradient(90deg, rgb(198, 238, 184) 30%, rgb(180, 196, 159) 100%);\n    background: linear-gradient(180deg, rgb(198, 238, 184) 30%, rgb(180, 196, 159) 100%);\n    box-shadow: 0 3px 4px -3px #ccc;\n}\n\noffice|annotation > dc|creator {\n    display: block;\n    font-size: 10pt;\n    font-weight: normal;\n    font-style: normal;\n    font-family: sans-serif;\n    color: white;\n    background-color: brown;\n    padding: 4px;\n}\noffice|annotation > dc|date {\n    display: block;\n    font-size: 10pt;\n    font-weight: normal;\n    font-style: normal;\n    font-family: sans-serif;\n    border: 4px solid transparent;\n    color: black;\n}\noffice|annotation > text|list {\n    display: block;\n    padding: 5px;\n}\n\n/* This is very temporary CSS. This must go once\n * we start bundling webodf-default ODF styles for annotations.\n */\noffice|annotation text|p {\n    font-size: 10pt;\n    color: black;\n    font-weight: normal;\n    font-style: normal;\n    text-decoration: none;\n    font-family: sans-serif;\n}\n\ndc|*::selection {\n    background: transparent;\n}\ndc|*::-moz-selection {\n    background: transparent;\n}\n\n#annotationsPane {\n    background-color: #EAEAEA;\n    width: 4cm;\n    height: 100%;\n    display: none;\n    position: absolute;\n    outline: 1px solid #ccc;\n}\n\n.annotationHighlight {\n    background-color: yellow;\n    position: relative;\n}\n\n.selectionOverlay {\n    position: absolute;\n    pointer-events: none;\n    top: 0;\n    left: 0;\n    top: 0;\n    left: 0;\n    width: 100%;\n    height: 100%;\n    z-index: 15;\n}\n.selectionOverlay > polygon {\n    fill-opacity: 0.3;\n    stroke-opacity: 0.8;\n    stroke-width: 1;\n    fill-rule: evenodd;\n}\n\n#imageSelector {\n    display: none;\n    position: absolute;\n    border-style: solid;\n    border-color: black;\n}\n\n#imageSelector > div {\n    width: 5px;\n    height: 5px;\n    display: block;\n    position: absolute;\n    border: 1px solid black;\n    background-color: #ffffff;\n}\n\n#imageSelector > .topLeft {\n    top: -4px;\n    left: -4px;\n}\n\n#imageSelector > .topRight {\n    top: -4px;\n    right: -4px;\n}\n\n#imageSelector > .bottomRight {\n    right: -4px;\n    bottom: -4px;\n}\n\n#imageSelector > .bottomLeft {\n    bottom: -4px;\n    left: -4px;\n}\n\n#imageSelector > .topMiddle {\n    top: -4px;\n    left: 50%;\n    margin-left: -2.5px; /* half of the width defined in #imageSelector > div */\n}\n\n#imageSelector > .rightMiddle {\n    top: 50%;\n    right: -4px;\n    margin-top: -2.5px; /* half of the height defined in #imageSelector > div */\n}\n\n#imageSelector > .bottomMiddle {\n    bottom: -4px;\n    left: 50%;\n    margin-left: -2.5px; /* half of the width defined in #imageSelector > div */\n}\n\n#imageSelector > .leftMiddle {\n    top: 50%;\n    left: -4px;\n    margin-top: -2.5px; /* half of the height defined in #imageSelector > div */\n}\n';
