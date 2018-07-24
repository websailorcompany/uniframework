var i = 0;
var o = new Object;
function timedCount() {
    i = i + 1;
    if(i<30){
      o.answer = "continue";
      o.dado = i;
      postMessage(o);
    }else{
      o.answer = "finished";
      postMessage(o);
    }
    setTimeout("timedCount()",500);
}
timedCount();
