Page({
    // mixins: [require('../../mixin/themeChanged')],
    goSubmit: function (event) {
		wx.switchTab({
			url: '../Postage/Postage',
		})
	},
	goSuggest: function (event) {
		wx.navigateTo({
		  url: '../suggest/suggest',
		})
	},
});