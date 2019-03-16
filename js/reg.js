var lstsend;
$(document).ready(function () {
	var teml, tcde, teck, tuser;
	var felm = false, fcde = false, feck = false, fusr = false, fpwd = false, frep = false;
	$("#inputEmail").blur(function () {
		var reemil = $("#inputEmail").val();
		if (reemil != teml) {
			teml = reemil;
			$("#regemail").attr("class", "form-group has-warning");
			var regm = new RegExp("^[0-9a-zA-Z_]+(\\.[0-9a-zA-Z_]+)*@[0-9a-zA-Z_]+(\\.[0-9a-zA-Z_]+)+$", "i");

			if (!regm.test(reemil)) {
				felm = 0;
				$("#regemail").attr("class", "form-group has-error");
				$("#regemail").attr("data-content", "邮箱格式填写错误，请重新填写！");
			}
			else {
				felm = 1;
				$("#regemail").attr("class", "form-group has-success");
				$("#regemail").attr("data-content", "邮箱可以使用！");
			}
		}
	});

	$("#inputchkcode").blur(function () {
		var recde = $("#inputchkcode").val().trim();
		if (tcde != recde) {
			tcde = recde;
			$("#regchkcode").attr("class", "form-group has-warning");
			var regm = new RegExp("^[0-9a-zA-Z]{4}$", "i");
			if (!regm.test(recde)) {
				$("#regchkcode").attr("class", "form-group has-error");
				$("#regchkcode").attr("data-content", "验证码填写错误！");
			}
			else {
				$.post(
					'/register/code',
					{ code: recde },
					function (data) {
						fcde = data.status;
						if (data.status)
							$("#regchkcode").attr("class", "form-group has-success");
						else
							$("#regchkcode").attr("class", "form-group has-error");
						$("#regchkcode").attr("data-content", data.mess);
					},
					"json"
				);
			}
		}
	});

	$("#btnchkmail").click(function () {
		if (felm && fcde) {
			$.post(
				'/register/sendemil',
				{ email: teml, code: tcde },
				function (data) {
					if (data.status) {
						lstsend = new Date();
						emildjs();
					}
					alert(data.mess);
				},
				"json"
			);
		}
	});

	$("#inputemlcode").blur(function () {
		var emlcode = $("#inputemlcode").val().trim();
		if (teck != emlcode) {
			teck = emlcode;
			$("#regemlcode").attr("class", "form-group has-warning");
			var regm = new RegExp("^[0-9a-zA-Z]{10}$", "i");
			if (!regm.test(emlcode)) {
				$("#regemlcode").attr("class", "form-group has-error");
				$("#regemlcode").attr("data-content", "验证码填写错误！");
			}
			else {
				$.post(
					'/register/mailcode',
					{ email: teml, emailcode: emlcode },
					function (data) {
						feck = data.status;
						if (data.status)
							$("#regemlcode").attr("class", "form-group has-success");
						else
							$("#regemlcode").attr("class", "form-group has-error");
						$("#regemlcode").attr("data-content", data.mess);
					},
					"json"
				);
			}
		}
	});

	$("#inputUsername").blur(function () {
		var rusr = $("#inputUsername").val().trim();
		if (rusr != tuser) {
			tuser = rusr;
			$("#regusername").attr("class", "form-group has-warning");
			var regu = new RegExp("^[-0-9a-zA-Z_\u4e00-\u9fa5]+$", "i");
			if (!regu.test(rusr)) {
				fusr = 0;
				$("#regusername").attr("class", "form-group has-error");
				$("#regusername").attr("data-content", "用户名填写错误，请重新填写！");
			}
			else {
				fusr = 1;
				$("#regusername").attr("class", "form-group has-success");
				$("#regusername").attr("data-content", data.mess);

			}
		}
	});

	$("#inputPassword").blur(function () {
		var pwd1 = $("#inputPassword").val();
		var pwd2 = $("#inputrepwd").val();
		if (pwd1.length >= 6 && pwd1.length <= 20) {
			fpwd = true;
			$("#regpassword").attr("class", "form-group has-success");
			$("#regpassword").attr("data-content", "您可以使用该密码！");
		}
		else {
			fpwd = false;
			$("#regpassword").attr("class", "form-group has-error");
			$("#regpassword").attr("data-content", "密码长度太长或太短。");
		}
		if (pwd2.length) {
			if (pwd1 == pwd2) {
				fpwd = true;
				$("#regcheckpwd").attr("class", "form-group has-success");
				$("#regcheckpwd").attr("data-content", "两次输入的密码一致。");
			}
			else {
				fpwd = false;
				$("#regcheckpwd").attr("class", "form-group has-error");
				$("#regcheckpwd").attr("data-content", "两次输入的密码不一致。");
			}
		}
	});

	$("#inputrepwd").blur(function () {
		var pwd1 = $("#inputPassword").val();
		var pwd2 = $("#inputrepwd").val();
		if (pwd1) {
			if (pwd1 == pwd2) {
				frep = true;
				fpwd = true;
				$("#regcheckpwd").attr("class", "form-group has-success");
				$("#regcheckpwd").attr("data-content", "两次输入的密码一致。");
			}
			else {
				frep = false;
				fpwd = false;
				$("#regcheckpwd").attr("class", "form-group has-error");
				$("#regcheckpwd").attr("data-content", "两次输入的密码不一致。");
			}
		}
		else {
			frep = false;
			$("#regcheckpwd").attr("class", "form-group has-error");
			$("#regcheckpwd").attr("data-content", "还没有输入密码。");
		}
	});

	pstreginf = function () {
		var ers = "";
		if (felm == false)
			ers = ers + "邮箱填写错误！\n";
		if (fusr == false)
			ers = ers + "用户名填写错误！\n";
		if (fpwd == false)
			ers = ers + "密码填写错误！\n";
		if (frep == false)
			ers = ers + "重复密码填写错误！\n";
		if (ers.length == 0)
			return true;
		else {
			alert(ers);
			return false;
		}
	}

});

$(function () {
	$("#regemail").popover({ placement: 'bottom', trigger: 'hover' });
	$("#regchkcode").popover({ placement: 'bottom', trigger: 'hover' });
	$("#regemlcode").popover({ placement: 'bottom', trigger: 'hover' });
	$("#regusername").popover({ placement: 'bottom', trigger: 'hover' });
	$("#regpassword").popover({ placement: 'bottom', trigger: 'hover' });
	$("#regcheckpwd").popover({ placement: 'bottom', trigger: 'hover' });
});

emildjs = function () {
	var slo = parseInt((new Date() - lstsend) / 1000);
	if (slo >= 0 && slo < 60) {
		$("#btnchkmail").text("验证邮箱(" + (60 - slo) + ")");
		setTimeout(emildjs, 1000);
	}
	else {
		$("#btnchkmail").text("验证邮箱");
	}
}