var $jscomp=$jscomp||{};$jscomp.scope={};$jscomp.ASSUME_ES5=!1;$jscomp.ASSUME_NO_NATIVE_MAP=!1;$jscomp.ASSUME_NO_NATIVE_SET=!1;$jscomp.SIMPLE_FROUND_POLYFILL=!1;$jscomp.objectCreate=$jscomp.ASSUME_ES5||"function"==typeof Object.create?Object.create:function(a){var b=function(){};b.prototype=a;return new b};$jscomp.underscoreProtoCanBeSet=function(){var a={a:!0},b={};try{return b.__proto__=a,b.a}catch(c){}return!1};
$jscomp.setPrototypeOf="function"==typeof Object.setPrototypeOf?Object.setPrototypeOf:$jscomp.underscoreProtoCanBeSet()?function(a,b){a.__proto__=b;if(a.__proto__!==b)throw new TypeError(a+" is not extensible");return a}:null;
$jscomp.inherits=function(a,b){a.prototype=$jscomp.objectCreate(b.prototype);a.prototype.constructor=a;if($jscomp.setPrototypeOf){var c=$jscomp.setPrototypeOf;c(a,b)}else for(c in b)if("prototype"!=c)if(Object.defineProperties){var e=Object.getOwnPropertyDescriptor(b,c);e&&Object.defineProperty(a,c,e)}else a[c]=b[c];a.superClass_=b.prototype};var bestscore=0,game_settings={sound:!0},storage_key="rf.tennis";load_data();function load_data(){var a=get_data(storage_key);a&&(bestscore=a)}
var Menu=function(){return Phaser.Scene.call(this,"menu")||this};$jscomp.inherits(Menu,Phaser.Scene);
Menu.prototype.create=function(){var a=this,b=this;this.add.sprite(config.width/2,config.height/2,"background");var c=this.add.sprite(360,190,"game_title");this.tweens.add({targets:c,y:c.y+30,duration:1300,ease:"Sine.easeInOut",yoyo:!0,repeat:-1});this.add.sprite(360,640,"bar_bestscore_large");this.add.text(360,650,bestscore,{fontFamily:"vanilla",fontSize:33,align:"left",color:"#ffffff"}).setOrigin(.5);draw_button(360,790,"start",this);this.input.on("gameobjectdown",function(c,d){d.button&&(play_sound("click",
a),a.tweens.add({targets:d,scaleX:.9,scaleY:.9,yoyo:!0,ease:"Linear",duration:100,onComplete:function(){"start"===d.name&&(show_ad(),b.scene.start("game"))}},a))},this);this.add.text(360,1040,dev_str,{fontFamily:"vanilla",fontSize:20,align:"center",color:"#FFFFFF"}).setOrigin(.5)};
