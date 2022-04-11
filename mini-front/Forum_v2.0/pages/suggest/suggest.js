// pages/suggest/suggest.js
Page({

	/**
	 * 页面的初始数据
	 */
	data: {
		showTopTips: false,
		contact: "",
		text: "",
		words1: 0,
		words2: 0,
	},

	getTitle: function(e) {
		this.setData({
			contact: e.detail.value,
			words1: e.detail.value.length
		})
	},
	getText: function(e) {
		this.setData({
			text: e.detail.value,
			words2: e.detail.value.length
		})
	},

	empty: function(e) {
		this.setData({
			showTopTips: false,
			contact: "",
			text: "",
			words1: 0,
			words2: 0,
		})
	},

	showTopTips(flag) {
		if (!getApp().checkShut()) {
			return;
		}
		if (this.data.contact == "" || this.data.text == "") {
			return;
		}
		var that = this
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/sendSuggest.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				contact: that.data.contact,
				text: that.data.text
			},
			method: 'GET',
			success:function(res) {
				console.log(res);
				that.empty();
			}
		})  // requext



		this.setData({
			showTopTips: false
		});
		wx.showToast({
			title: "发送成功",
			duration: 2000,
			icon: "sucess",
			make: true
		})
	},

})