var $jscomp=$jscomp||{};$jscomp.scope={};$jscomp.ASSUME_ES5=!1;$jscomp.ASSUME_NO_NATIVE_MAP=!1;$jscomp.ASSUME_NO_NATIVE_SET=!1;$jscomp.SIMPLE_FROUND_POLYFILL=!1;$jscomp.objectCreate=$jscomp.ASSUME_ES5||"function"==typeof Object.create?Object.create:function(a){var b=function(){};b.prototype=a;return new b};$jscomp.underscoreProtoCanBeSet=function(){var a={a:!0},b={};try{return b.__proto__=a,b.a}catch(c){}return!1};
$jscomp.setPrototypeOf="function"==typeof Object.setPrototypeOf?Object.setPrototypeOf:$jscomp.underscoreProtoCanBeSet()?function(a,b){a.__proto__=b;if(a.__proto__!==b)throw new TypeError(a+" is not extensible");return a}:null;
$jscomp.inherits=function(a,b){a.prototype=$jscomp.objectCreate(b.prototype);a.prototype.constructor=a;if($jscomp.setPrototypeOf){var c=$jscomp.setPrototypeOf;c(a,b)}else for(c in b)if("prototype"!=c)if(Object.defineProperties){var d=Object.getOwnPropertyDescriptor(b,c);d&&Object.defineProperty(a,c,d)}else a[c]=b[c];a.superClass_=b.prototype};var dev_str="Developed by GimCraft.com",Load=function(){return Phaser.Scene.call(this,"load")||this};$jscomp.inherits(Load,Phaser.Scene);
Load.prototype.preload=function(){var a=this;this.add.sprite(config.width/2,config.height/2,"background");this.add.sprite(360,250,"game_title");var b=this.add.rectangle(config.width/2,900,600,20);b.setStrokeStyle(4,16777215);b.alpha=.7;var c=this.add.rectangle(config.width/2,900,590,10,16777215);c.alpha=.8;this.load.on("progress",function(a){c.width=590*a});this.load.on("complete",function(){b.destroy();c.destroy();var d=draw_button(360,800,"start",a);a.tweens.add({targets:d,alpha:.5,yoyo:!0,duration:300,
loop:-1})},this);this.input.on("gameobjectdown",function(){a.scene.start("menu")},this);this.load.image("back","img/back.png");this.load.image("header","img/header.png");this.load.image("footer","img/footer.png");this.load.image("popup","img/popup.png");this.load.image("progress","img/progress.png");this.load.image("best_bar_large","img/best_bar_large.png");this.load.image("btn_pause","img/btn_pause.png");this.load.image("btn_resume","img/btn_resume.png");this.load.image("btn_restart","img/btn_restart.png");
this.load.image("btn_menu","img/btn_menu.png");this.load.image("btn_sound_on","img/btn_sound_on.png");this.load.image("btn_sound_off","img/btn_sound_off.png");this.load.image("paused","img/paused.png");this.load.image("gameover","img/gameover.png");this.load.image("score_bar","img/score_bar.png");this.load.image("best_bar","img/best_bar.png");this.load.spritesheet("tiles","img/tiles.png",{frameWidth:128,frameHeight:130});this.load.audio("click","audio/click.mp3");this.load.audio("completed","audio/completed.mp3");
this.load.audio("gameover","audio/gameover.mp3");this.load.audio("match","audio/match.mp3");this.load.audio("flip","audio/flip.mp3")};
