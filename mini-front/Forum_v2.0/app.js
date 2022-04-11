// app.js
// 其他页面使用 getApp() 调用
App({
	// 全局变量
	
	globalData: {
		user: {},
		userId: "",
		userFlag: "",
		shutFlag: "",
		blackFlag: "",
    },
	checkShut: function () {
		if (getApp().globalData.shutFlag == '1') {
			wx.showModal({
				title: "你已被禁言",
				showCancel: false,
			})
			return false;
		} else {
			return true;
		}
	},
	checkBlack: function () {
		if (getApp().globalData.blackFlag == '1') {
			wx.showModal({
				title: "你已被拉黑",
				showCancel: false,
			})
			return false;
		} else {
			return true;
		}
	},
	sendUserInfo: function(userId, userName, userSex, userImgUrl) {
		var that = this;
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/setUserInfo.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				userId: userId,
				userName: userName,
				userSex: userSex,
				userImgUrl: userImgUrl
			},
			method: 'post',
			success:function(res) {
				console.log(res)
				that.globalData.user = {
					userId: that.globalData.userId,
					userFlag: '1'
				}
				that.globalData.userId = that.globalData.userId,
				that.globalData.userFlag = '1'
			}
		})
	},
	onLaunch() {
		var that = this;
        // 登录
        wx.login({
			success(res) {
				if (res.code){
					wx.request({
						url: '"这儿是请求的后端地址，需要替换成自己的"/request/login_new.php',
						header: {//json
							'content-type': 'application/x-www-form-urlencoded',
						},
						data: {
							code: res.code,
						},
						method: 'post',
						success:function(res) {
							console.log(res)
							that.globalData.user = res.data.user
							that.globalData.userId = res.data.user.userId
							that.globalData.userFlag = res.data.user.userFlag
							that.globalData.shutFlag = res.data.shutFlag
							that.globalData.blackFlag = res.data.blackFlag
						}
					})
				} else {
					console.log('登录失败！' + res.errMsg)
				}
			},
			fail: function(res) {

			}
		})
	},  // onlounch
})
