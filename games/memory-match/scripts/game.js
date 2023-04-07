var $jscomp=$jscomp||{};$jscomp.scope={};$jscomp.ASSUME_ES5=!1;$jscomp.ASSUME_NO_NATIVE_MAP=!1;$jscomp.ASSUME_NO_NATIVE_SET=!1;$jscomp.SIMPLE_FROUND_POLYFILL=!1;$jscomp.objectCreate=$jscomp.ASSUME_ES5||"function"==typeof Object.create?Object.create:function(a){var c=function(){};c.prototype=a;return new c};$jscomp.underscoreProtoCanBeSet=function(){var a={a:!0},c={};try{return c.__proto__=a,c.a}catch(g){}return!1};
$jscomp.setPrototypeOf="function"==typeof Object.setPrototypeOf?Object.setPrototypeOf:$jscomp.underscoreProtoCanBeSet()?function(a,c){a.__proto__=c;if(a.__proto__!==c)throw new TypeError(a+" is not extensible");return a}:null;
$jscomp.inherits=function(a,c){a.prototype=$jscomp.objectCreate(c.prototype);a.prototype.constructor=a;if($jscomp.setPrototypeOf){var g=$jscomp.setPrototypeOf;g(a,c)}else for(g in c)if("prototype"!=g)if(Object.defineProperties){var u=Object.getOwnPropertyDescriptor(c,g);u&&Object.defineProperty(a,g,u)}else a[g]=c[g];a.superClass_=c.prototype};var cur_level=1,default_max_type=20,cur_time=0,_score=0,Game=function(){return Phaser.Scene.call(this,"game")||this};$jscomp.inherits(Game,Phaser.Scene);
Game.prototype.create=function(){function a(d,y){if("open"==y){var z=d.back;var e=d;d.open=!0}else z=d,e=d.back;e.scaleX=0;b.tweens.add({targets:z,scaleX:0,duration:100,onComplete:function(){b.tweens.add({targets:e,scaleX:.7,duration:100,onComplete:function(){d.scaleX=.7;"open"==y?"play"==m&&(h.push({id:d.id,frame:d.frame.name}),2==h.length&&(h[0].frame==h[1].frame?(g(h[0]),g(h[1]),play_sound("match",b),f+=2,A(),h=[],0==k.length&&F()):(a(c(h[0].id),"close"),h.shift()))):(d.open=!1,"wait"==m&&(B++,
B==k.length&&(m="play")))}})}})}function c(d){for(var b=k.length,a=0;a<b;a++)if(k[a].id==d)return k[a]}function g(b){for(var d=c(b.id),a=0;a<k.length;a++)if(b.id==k[a].id){u(d);d.destroy(!0,!0);k.splice(a,1);break}}function u(d){var a=b.add.sprite(d.x,d.y,"tiles");a.setFrame(d.frame.name);a.setScale(.7);b.tweens.add({targets:a,rotation:Phaser.Math.DegToRad(500),scaleX:0,scaleY:0,duration:400,onComplete:function(){a.destroy(!0,!0)}})}function F(){play_sound("completed",b);m="completed";b.time.delayedCall(400,
function(){cur_level++;_score=f;submit_score(f);b.scene.restart()})}function A(){f>bestscore&&(bestscore=f,G.setText(bestscore));H.setText(f);f>=bestscore&&save_data(storage_key,bestscore)}var I=this,b=this,l=0;1<=cur_level&&0<cur_time&&(l=cur_time);var f=0;1<cur_level&&0<_score&&(f=_score,_score=0);var n=null;n=rf_stage.length>cur_level?rf_stage[cur_level-1]:default_stage;this.add.sprite(0,0,"background").setOrigin(0);this.add.sprite(config.width/2,0,"header").setOrigin(.5,0);this.add.sprite(config.width/
2,config.height,"footer").setOrigin(.5,1);var H=this.add.text(245,60,f,{fontFamily:"vanilla",fontSize:33,align:"right",color:"#FFFFFF"}).setOrigin(1,.5),G=this.add.text(510,60,bestscore,{fontFamily:"vanilla",fontSize:33,align:"right",color:"#FFFFFF"}).setOrigin(1,.5);A();var v=n.col,w=n.row,q=n.max_type?n.max_type:default_max_type;n=(config.width-94.5*v)/2+47.25;var C=(config.height-94.5*w)/2+47.25,r=0,B=0;0==cur_time&&(l=360);for(var h=[],k=[],t=[],m="wait",D=this.add.group(),p=0;p<w*v/2;p++)t.push(Math.floor(Math.random()*
q));t=t.concat(t);t=function(b){for(var a=b.length-1;0<a;a--){var d=Math.floor(Math.random()*(a+1)),c=b[a];b[a]=b[d];b[d]=c}return b}(t);for(q=0;q<w;q++)for(p=0;p<v;p++){var e=this.add.sprite(n+94.5*p,C+94.5*q,"tiles");e.setInteractive();e.name="tile";e.setFrame(t[r]);e.pos={x:p,y:q};e.id=r;e.setScale(.7);e.back=this.add.sprite(n+94.5*p,C+94.5*q,"back");e.back.setScale(.7);k.push(e);r++}var E=k.length;r=0;this.time.addEvent({delay:200,repeat:E-1,callback:function(){play_sound("flip",b);var d=c(r);
a(d,"open");I.time.delayedCall(1E3,function(){a(d,"close");r>=E&&(h=[])});r++}});draw_button(615,60,"pause",this);var x=this.add.tileSprite(26,1040,668,30,"progress");x.setOrigin(0,.5);x.scaleX=l/360;this.time.addEvent({delay:300,loop:!0,callback:function(){if("play"==m)if(0<l)cur_time=--l,0>l&&(l=0),x.scaleX=l/360;else{play_sound("gameover",b);submit_score(f);f>=bestscore&&save_data(storage_key,bestscore);m="gameover";var a=b.add.rectangle(0,0,config.width,config.height,0).setOrigin(0);a.setInteractive();
a.alpha=0;b.tweens.add({targets:a,alpha:.5,duration:200});b.add.sprite(360,570,"popup");b.add.sprite(360,285,"gameover");b.add.sprite(360,475,"score_bar");b.add.sprite(347,625,"best_bar");b.add.text(500,475,f,{fontFamily:"vanilla",fontSize:40,align:"right",color:"#FFFFFF"}).setOrigin(1,.5);b.add.text(500,625,bestscore,{fontFamily:"vanilla",fontSize:40,align:"right",color:"#FFFFFF"}).setOrigin(1,.5);draw_button(240,760,"restart",b);draw_button(360,760,"menu",b);a=draw_button(480,760,"sound_on",b);
check_audio(a);f=0}}});this.input.on("gameobjectdown",function(d,c){"tile"!=c.name||"play"!=m||c.open||(play_sound("flip",b),a(c,"open"));c.button&&(play_sound("click",b),b.tweens.add({targets:c,scaleX:.95,scaleY:.95,yoyo:!0,duration:100,ease:"Linear",onComplete:function(){if("play"===m){if("pause"===c.name){m="paused";var a=b.add.rectangle(0,0,config.width,config.height,0).setOrigin(0);a.setInteractive();a.alpha=0;b.tweens.add({targets:a,alpha:.5,duration:200});var d=b.add.sprite(360,570,"popup"),
e=b.add.sprite(360,285,"paused"),g=draw_button(360,530,"resume",b),h=draw_button(240,740,"restart",b),k=draw_button(360,740,"menu",b),l=draw_button(480,740,"sound_on",b);check_audio(l);D.addMultiple([a,d,e,g,h,k,l])}}else"resume"===c.name&&(m="play",D.clear(!0,!0));"sound"===c.name?switch_audio(c):"restart"===c.name?(cur_level=1,cur_time=0,show_ad(),b.scene.restart()):"menu"===c.name&&(cur_level=1,cur_time=f=0,show_ad(),b.scene.start("menu"))}}))},this)};
var config={type:Phaser.AUTO,width:720,height:1080,scale:{mode:Phaser.Scale.FIT,parent:"game_content",autoCenter:Phaser.Scale.CENTER_BOTH},scene:[Boot,Load,Menu,Game]},game=new Phaser.Game(config);
