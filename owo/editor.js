function insertAtCursor(t, e) {
	var n, o, s = t.scrollTop,
		l = document.documentElement.scrollTop;
	document.selection ? (t.focus(), (n = document.selection.createRange()).text = e, n.select()) : t.selectionStart || "0" == t.selectionStart ? (n = t.selectionStart, o = t.selectionEnd, t.value = t.value.substring(0, n) + e + t.value.substring(o, t.value.length), t.focus(), t.selectionStart = n + e.length, t.selectionEnd = n + e.length) : (t.value += e, t.focus()), t.scrollTop = s, document.documentElement.scrollTop = l
}
$(function() {
	0 < $("#wmd-button-row").length && ($("#wmd-button-row").append('<li class="wmd-spacer wmd-spacer1"></li><li class="wmd-button" id="wmd-owo-button" style="" title="插入表情"><span style="width:unset" class="OwO"></span></li>'), new OwO({
		logo: "OωO",
		container: document.getElementsByClassName("OwO")[0],
		target: document.getElementById("text"),
		api: "/usr/plugins/OwOHP/owo/OwOHP.json",
		position: "down",
		width: "400px",
		maxHeight: "250px"
	}))
});