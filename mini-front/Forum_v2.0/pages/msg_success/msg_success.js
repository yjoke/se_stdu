Page({
    // mixins: [require('../../mixin/themeChanged')],
    goHome: function (event) {
		wx.switchTab({
			url: '../index/index',
		})
	},
	goSuggest: function (event) {
		wx.navigateTo({
		  url: '../suggest/suggest',
		})
	},
});