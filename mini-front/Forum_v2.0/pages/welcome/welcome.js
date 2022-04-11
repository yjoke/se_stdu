// pages/welcome/welcome.js
Page({

	/**
	 * 页面的初始数据
	 */
	data: {
		isLoad: true,
		time: 3,
	},

	/**
	 * 生命周期函数--监听页面加载
	 */
	countDown: function(func) {
		var that = this;
		setTimeout(() => {
			console.log(that.data.time)//
			if (getApp().checkBlack() && (!that.data.isLoad || that.data.time == 0)) {
				wx.switchTab({
					url: '/pages/index/index',
				})
				return;
			}
			that.setData({
				time: --that.data.time
			})
			setTimeout(() => {
                func(func)
            }, 100);
		}, 900);
	},
	onLoad: function(options) {
		this.countDown(this.countDown)
	},
	next() {
		this.setData({
			isLoad: false
		})
	},
	/**
	 * 用户点击右上角分享
	 */
	onShareAppMessage: function() {
		return {
			title: "石铁大校园论坛，“坛”你所想",
			imageUrl: "/images/other/logo.png"
		}

	}
})