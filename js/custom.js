$.ajaxSetup({
	async: true
});
var kmmx = 2;
var encrypt = [];
for (var ki = 1; ki <= kmmx; ki++) {
	(function (kid) {
		encrypt[kid] = new JSEncrypt();
		$.get('/public' + kid + '.key', function (kdata) {
			encrypt[kid].setPublicKey(kdata);
			//console.log(kdata);
		});
	})(ki);
}
//console.log(encrypt);
$(function () {
	$("[data-stopPropagation]").click(function (e) {
		e.stopPropagation();
	});
});
$("#btnLogin").click(function () {
	var datt = {};
	var lgpwd = $("#password").val();
	datt.username = $("#username").val().trim();
	datt.checkcode = $("#checkcode").val().trim();
	for (var ki = 1; ki <= kmmx; ki++)
		datt['password' + ki] = encrypt[ki].encrypt(lgpwd);
	$.post(
		'/login',
		datt,
		function (data) {
			if (data.status) {
				alert(data.status);
				$(".captcha").attr("src", "/checkcode.png?" + Math.random());
			}
			else
				location.reload();
		},
		"json"
	);
});

function pstcode() {
	try {
		var str = myCodeMirror.getValue();
		myCodeMirror.setValue('正在处理……');
		var resu1 = '';
		var resu2 = '';
		var len = str.length;
		//console.log(len);
		for (var i = 0; i < len / 117; i++) {
			var tempstr = str.substring(i * 117, Math.min((i + 1) * 117, len));
			resu1 += encrypt[1].encrypt(tempstr) + '\n';
			resu2 += encrypt[2].encrypt(tempstr) + '\n';
			if (i % 50 == 0)
				console.log('正在处理……' + ((i + 1) * 100 / (len / 117)).toFixed(2) + '%');
		}
		$('#code1').val(resu1);
		$('#code2').val(resu2);
		myCodeMirror.setValue('正在上传代码……');
		return true;
	}
	catch (e) {
		console.log(e);
		return false;
	}
}

$("#btnqiandao").click(function () {
	$.get(
		'/qiandao',
		function (data) {
			if (data.status) {
				if (data.time) {
					data.status += "<br/>签到时间：";
					var ttm = new Date(data.time);
					data.status += ttm.getFullYear() + '-' + (ttm.getMonth() + 1) + '-' + ttm.getDate() + ' ' + ttm.getHours() + ':' + ttm.getMinutes() + ':' + ttm.getSeconds();
				}
				$("#qiandaomsg").html(data.status);
				$('#qiandaoModal').modal();
			}
			else
				location.reload();
		},
		"json"
	);
});
$("#btnfq").click(function () {
	$.get(
		'/qiandao/feiqiu',
		function (data) {
			if (data.status) {
				if (data.time) {
					data.status += "<br/>签到时间：";
					var ttm = new Date(data.time);
					data.status += ttm.getFullYear() + '-' + (ttm.getMonth() + 1) + '-' + ttm.getDate() + ' ' + ttm.getHours() + ':' + ttm.getMinutes() + ':' + ttm.getSeconds();
				}
				$("#qiandaomsg").html(data.status);
				$('#qiandaoModal').modal();
			}
			else
				location.reload();
		},
		"json"
	);
});
$("#btnoh").click(function () {
	$.get(
		'/qiandao/ouhuang',
		function (data) {
			if (data.status) {
				if (data.time) {
					data.status += "<br/>签到时间：";
					var ttm = new Date(data.time);
					data.status += ttm.getFullYear() + '-' + (ttm.getMonth() + 1) + '-' + ttm.getDate() + ' ' + ttm.getHours() + ':' + ttm.getMinutes() + ':' + ttm.getSeconds();
				}
				$("#qiandaomsg").html(data.status);
				$('#qiandaoModal').modal();
			}
			else
				location.reload();
		},
		"json"
	);
});
$("#Logout").click(function () {
	$.post('/logout', {}, function (data) {
		if (data.status)
			alert(data.status);
		else
			location.reload();
	}, "json");
});
$(".captcha").click(function () {
	$(this).attr("src", "/checkcode.png?" + Math.random());
});

var myCodeMirror = null;
var codemode = {
	"C": "text/x-csrc",
	"gcc": "text/x-csrc",
	"g++": "text/x-c++src",
	"C++": "text/x-c++src",
	"Java": "text/x-java",
	'Python2.7': {
		name: "python",
		version: 2,
		singleLineStringErrors: false
	},
	'Python3.6': {
		name: "python",
		version: 3,
		singleLineStringErrors: false
	}
};
$("#submitcode").on('shown.bs.modal', function () {
	if (!myCodeMirror) myCodeMirror = CodeMirror.fromTextArea($('#codeeditor')[0], {
		indentUnit: 4,
		lineNumbers: true,
		matchBrackets: true,
		mode: codemode[$("#language").val()]
	});
});
$("#language").click(function () {

	myCodeMirror.setOption('mode', codemode[localStorage.deflan = $(this).val()]);
});
$("[data-href]").click(function () {
	var self = $(this);
	location.href = self.attr("data-hrefhead") + $(self.attr("data-href")).val();
});

$("[data-status]").each(function () {
	var that = $(this);
	var cls = {
		'Accepted': 'label-success',
		'Presentation Error': 'label-danger',
		'Time Limit Exceeded': 'label-danger',
		'Memory Limit Exceeded': 'label-danger',
		'Wrong Answer': 'label-danger',
		'Runtime Error': 'label-danger',
		'Output Limit Exceeded': 'label-danger',
		'Compile Error': 'label-warning',
		'System Error': 'label-danger'
	}[that.attr('data-status')];
	if (!cls) cls = "label-primary";
	that.addClass(cls);
});
$("[data-enter]").keydown(function (event) {
	if (event.keyCode == 13) $($(this).attr('data-enter')).click();
});
$("[data-ctrlenter]").keydown(function (event) {
	if (event.keyCode == 13 && event.ctrlKey) $($(this).attr('data-ctrlenter')).click();
});
$("#searchproblem").click(function () {
	var kw = $("#problemkw").val().trim();
	if (kw.match(/^\d{4,5}$/))
		location.href = "./../P/" + kw;
	else
		this.form.submit();
});
if (!localStorage.deflan) localStorage.deflan = "C++";
$("#language").val(localStorage.deflan);
$(function () {
	$("#popfq").popover({ placement: 'bottom', trigger: 'hover' });
	$("#popoh").popover({ placement: 'bottom', trigger: 'hover' });
	$("#StatusTitle").popover({ placement: 'bottom', trigger: 'hover' });
});