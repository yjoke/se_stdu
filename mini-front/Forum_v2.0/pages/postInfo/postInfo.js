// pages/textfinish/textfinish.js
Page({
	/**
	 * 页面的初始数据
	 */
	data: {
		userId: null,  // 进入帖子的用户 id
		postId: null,  // 帖子的 id
		post: null,  // 帖子的相关内容
		user: null,  // 帖子所属的用户信息
		comments: null,  // 评论信息
		commentFlag: false,  // 评论图标显示
		likeFlag: null,  // 点赞
		commentText: "",  // 待发送的评论
		delDiaFlag: false,  // 删除确认框的标志
		toast: false,  // 成功
		warnToast: false,  // 失败
	},

	previewImage: function(e){
		wx.previewImage({
			current: this.data.post.postImgUrl[e.currentTarget.id], // 当前显示图片的http链接
			urls: this.data.post.postImgUrl // 需要预览的图片http链接列表
		})
	},

	openToast: function() {
        this.setData({
            toast: true
        });
        setTimeout(() => {
            this.setData({
                hideToast: true
            });
            setTimeout(() => {
                this.setData({
                    toast: false,
                    hideToast: false,
				});
				wx.switchTab({
					url: '/pages/index/index',
				})
            }, 300);
        }, 1500);
    },
    openWarnToast: function() {
        this.setData({
            warnToast: true
        });
        setTimeout(() => {
            this.setData({
                hidewarnToast: true
            });
            setTimeout(() => {
                this.setData({
                    warnToast: false,
                    hidewarnToast: false,
                });
            }, 300);
        }, 3000);
    },
	delete: function () {
		this.setData({
			delDiaFlag: true
		})
	},

	close: function () {
		this.setData({
			delDiaFlag: false
		})
	},
	affirm: function () {
		this.setData({
			delDiaFlag: false
		})
		var that = this;
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/delPost.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				postId: this.data.postId
			},
			method: 'POST',
			success: function(res) {
				console.log(res)
				if (res.data.delPostFlag == "true") {
					that.openToast();
				} else {
					that.openWarnToast();
				}
			},
			file: function(res) {
				that.openWarnToast()
			}
		})  // requext
	},

	comment: function() {
		var that = this;
		this.setData({
			commentFlag: !this.data.commentFlag
		});
		if (this.data.comments != null) {
			return;
		}
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/getCommentInfo.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				postId: this.data.postId
			},
			method: 'post',
			success:function(res) {
				console.log(res)
				that.setData({
					comments: res.data.comments
				})
			}
		})
	},

	isLike: function() {
		var that = this;
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/isLike.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				postId: this.data.postId,
				userId: this.data.userId
			},
			method: 'POST',
			success:function(res) {
				console.log(res)
				var temp = true;
				if (res.data.likeFlag != '1') {
					temp = false;
				}
				that.setData({
					likeFlag: temp
				})
			}
		})  // requext
	},

	like: function() {
		var that = this;
		if (!this.data.likeFlag) {
			wx.request({
				url: '"这儿是请求的后端地址，需要替换成自己的"/request/likePost.php',
				header: {//json
					'content-type': 'application/x-www-form-urlencoded',
				},
				data: {
					postId: this.data.postId,
					userId: this.data.userId
				},
				method: 'POST',
				success:function(res) {
					console.log("1")
					console.log(res)
					if (res.data.likeFlag == "true") {
						that.setData({
							likeFlag: !that.data.likeFlag
						})
					}
				}
			})  // requext
		} else {
			wx.request({
				url: '"这儿是请求的后端地址，需要替换成自己的"/request/delLike.php',
				header: {//json
					'content-type': 'application/x-www-form-urlencoded',
				},
				data: {
					postId: this.data.postId,
					userId: this.data.userId
				},
				method: 'POST',
				success:function(res) {
					console.log("2")
					console.log(res)
					if (res.data.delLikeFlag == "true") {
						that.setData({
							likeFlag: !that.data.likeFlag
						})
					}
				}
			})  // requext
		}
	},

	getSend: function(e) {
		this.setData({
			commentText: e.detail.value
		})
		console.log(this.data.commentText);
	},

	sendComment: function() {
		if (!getApp().checkShut()) {
			return
		}
		if (this.data.commentText.length == 0) {
			return
		}
		var that = this;
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/sendComment.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				postId: this.data.postId,
				userId: this.data.userId,
				commentText: this.data.commentText
			},
			method: 'POST',
			success:function(res) {
				console.log(res)
				if (that.data.comments != null) {
					that.setData({
						comments: [{
							user: {
								userId: that.data.userId,
								userName: res.data.userName
							}, 
							replier: {
								userId: "",
								userName: "",
							}, 
							comment: {
								commentId: "",  // 这儿应该返回的
								commentText: that.data.commentText
							}
						}].concat(that.data.comments)
					})
				}
			that.setData({
				// commentFlag: true,
				commentText: ""
			})
			}
		})  // requext
	},

	delComment: function(event) {
		console.log(event)
		var commentId = event.currentTarget.dataset.commentid;
		var userId = event.currentTarget.dataset.userid;
		var index = event.currentTarget.dataset.index;
		console.log(userId)
		if (this.data.userId == this.data.user.userId) {  // 帖子主人
			this.del(commentId, index);
		} else if (userId == this.data.userId) {  // 自己的评论
			this.del(commentId, index);
		}
	},
	del: function(commentId, index) {
		var that = this
		wx.showModal({
			title: "是否删除",
			success: function(res) {
				console.log(res)
				console.log(commentId + " " + index)
				if (res.confirm) {
					wx.request({
						url: '"这儿是请求的后端地址，需要替换成自己的"/request/delComment.php',
						header: {//json
							'content-type': 'application/x-www-form-urlencoded',
						},
						data: {
							commentId: commentId,
						},
						method: 'POST',
						success:function(res) {
							console.log(commentId + " " + index)
							console.log(res)
							if (res.data.delCommentFlag == "true") {
								var comments = that.data.comments
								comments.splice(index, 1)
								that.setData({
									comments: comments
								})
								wx.showToast({
									title: "删除成功",
									duration:2000,
									icon:"sucess",
									make:true
								})
							} else {
								wx.showToast({
									title: "删除失败",
									duration:2000,
									icon:"error",
									make:true
								})
							}
						},
						fail: function (res) {
							wx.showToast({
								title: "删除失败",
								duration:2000,
								icon:"error",
								make:true
							})
						}
					})  // requext
				}
			}
		})
	},
	
	onLoad: function (options) {
		var that = this
		this.postId = options.postId,
		this.setData({
			postId: options.postId,
			userId: getApp().globalData.user.userId
		})
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/getPostInfo.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				postId: this.postId
			},
			method: 'post',
			success:function(res) {
				if (res.data.post == '0') {
					wx.setNavigationBarTitle({
						title: "帖子不存在"
					})
					return;
				}
				console.log(res)
				var str = res.data.post.postText
				res.data.post.postText = str.replace(/&&n&&/g, "\n")
				that.setData({
					post: res.data.post,
					user: res.data.user
				})
				wx.setNavigationBarTitle({
					title: res.data.post.postTitle
				})
			}
		})
		this.isLike();
	},

	/**
	 * 页面相关事件处理函数--监听用户下拉动作
	 */
	onPullDownRefresh: function () {
		//在当前页面显示导航条加载动画
        wx.showNavigationBarLoading(); 
        //显示 loading 提示框。需主动调用 wx.hideLoading 才能关闭提示框
        wx.showLoading({
          	title: '刷新中...',
		})
		// 发送数据请求
		var that = this;
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/getCommentInfo.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				postId: this.data.postId
			},
			method: 'post',
			success:function(res) {
				console.log(res)
				that.setData({
					comments: res.data.comments
				})
				//隐藏loading 提示框
                wx.hideLoading();
                //隐藏导航条加载动画
                wx.hideNavigationBarLoading();
                //停止下拉刷新
                wx.stopPullDownRefresh();
			}
		})  // requext
	},


	/**
	 * 用户点击右上角分享
	 */
	onShareAppMessage: function() {
		var postTitle = this.data.post.postTitle
		return {
			title: "石铁大校园论坛: " + postTitle,
			imageUrl: "/images/other/logo.png"
		}
	}
})