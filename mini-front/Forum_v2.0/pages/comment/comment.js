// pages/comment/comment.js
Page({

	/**
	 * 页面的初始数据
	 */
	data: {
		comment: null,
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
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/getReply.php',
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
					comment: res.data.reply
				})
			}
		})  // requext
	},
	
	
	drawStart: function (e) {
		// console.log("drawStart");  
		var touch = e.touches[0]
	
		for(var index in this.data.comment) {
			var item = this.data.comment[index]
			item.right = 0
		}
		this.setData({
			comment: this.data.comment,
			startX: touch.clientX,
		})
	
	  },
	drawMove: function (e) {
		var touch = e.touches[0]
		var item = this.data.comment[e.currentTarget.dataset.index]
		var disX = this.data.startX - touch.clientX
		
		if (disX >= 20) {
			if (disX > this.data.delBtnWidth) {
				disX = this.data.delBtnWidth
			}
			item.right = disX
			this.setData({
				isScroll: false,
				comment: this.data.comment
			})
		} else {
			item.right = 0
			this.setData({
				isScroll: true,
				comment: this.data.comment
			})
		}
	  },  
	drawEnd: function (e) {
		var item = this.data.comment[e.currentTarget.dataset.index]
			if (item.right >= this.data.delBtnWidth/2) {
				item.right = this.data.delBtnWidth
				this.setData({
				isScroll: true,
				comment: this.data.comment,
				})
		} else {
			item.right = 0
			this.setData({
			isScroll: true,
			comment: this.data.comment,
			})
		}
	},

	delItem: function (e) {
		// console.log(e)
		var commentId = e.currentTarget.dataset.commentid
		var index = e.currentTarget.dataset.id
		// 删除
		var that = this
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/delCommentInfo.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				commentId: commentId
			},
			method: 'POST',
			success:function(res) {
				console.log(res)
				if (res.data.delFlag == "true") {
					var comment = that.data.comment;
					console.log(index)
					comment.splice(index, 1);
					that.setData({
						comment: comment
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