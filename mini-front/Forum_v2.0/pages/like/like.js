// pages/like/like.js
Page({

  /**
   * 页面的初始数据
   */
	data: {
		like: null,
		delBtnWidth:160,
		isScroll:true,
		windowHeight:0,
	},
	goPostInfo: function (event) {
		var postId = event.currentTarget.dataset.id;
		wx.navigateTo({
			url: '../postInfo/postInfo?postId=' + postId,
		})
	},
	/**
	 * 生命周期函数--监听页面加载
	 */
	onLoad: function (options) {
		var that = this;
		wx.getSystemInfo({
			success: function (res) {
			that.setData({
				windowHeight: res.windowHeight
			});
			}
		});
		// getLike
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/getLike.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				userId: getApp().globalData.user.userId
			},
			method: 'POST',
			success:function(res) {
				console.log(res)
				that.setData({
					like: res.data.like
				})
			}
		})  // requext
	},

	drawStart: function (e) {
		// console.log("drawStart");  
		var touch = e.touches[0]
	
		for(var index in this.data.like) {
			var item = this.data.like[index]
			item.right = 0
		}
		this.setData({
			like: this.data.like,
			startX: touch.clientX,
		})
	
	  },
	drawMove: function (e) {
		var touch = e.touches[0]
		var item = this.data.like[e.currentTarget.dataset.index]
		var disX = this.data.startX - touch.clientX
		
		if (disX >= 20) {
			if (disX > this.data.delBtnWidth) {
				disX = this.data.delBtnWidth
			}
			item.right = disX
			this.setData({
				isScroll: false,
				like: this.data.like
			})
		} else {
			item.right = 0
			this.setData({
				isScroll: true,
				like: this.data.like
			})
		}
	  },  
	drawEnd: function (e) {
		var item = this.data.like[e.currentTarget.dataset.index]
			if (item.right >= this.data.delBtnWidth/2) {
				item.right = this.data.delBtnWidth
				this.setData({
				isScroll: true,
				like: this.data.like,
				})
		} else {
			item.right = 0
			this.setData({
			isScroll: true,
			like: this.data.like,
			})
		}
	},

	delItem: function (e) {
		// console.log(e)
		var postId = e.currentTarget.dataset.postid
		var userId = e.currentTarget.dataset.userid
		var index = e.currentTarget.dataset.id
		// 删除
		var that = this
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/delLikeInfo.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				postId: postId,
				userId: userId
			},
			method: 'POST',
			success:function(res) {
				console.log(res)
				if (res.data.delFlag == "true") {
					var like = that.data.like;
					like.splice(index, 1);
					that.setData({
						like: like
					})
					wx.showToast({
						title: "删除成功",
						duration: 2000,
						icon: "sucess",
						make: true
					})
				} else {
					wx.showToast({
						title: "删除成功",
						duration: 2000,
						icon: "sucess",
						make: true
					})
				}
			},
			fail: function(res) {
				console.log(res)
				wx.showToast({
					title: "删除失败",
					duration: 2000,
					icon: "error",
					make: true
				})
			}
		})  // requext
	}


})