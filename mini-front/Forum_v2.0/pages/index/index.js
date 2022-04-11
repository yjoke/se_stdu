// pages/index_v1.1/index_v1.1.js
Page({

	/**
	 * 页面的初始数据
	 */
	data: {
		inputShowed: false,  // 搜索框需要的判断条件
        inputVal: "",  // 搜索框的输入
		searchResult: [],  // 搜索结果
		slide: [], // 轮播图信息
		postType: ["表白找人", "二手市场", "失物招领", "其它"],  // 帖子类型
		post: [],  // 帖子信息
		current:0,
		authFlag: false,
		beginx: 0,
		endx: 0,
		Width: wx.getSystemInfoSync().windowWidth,
		src: "'这是请求的后端地址，需要换成自己的'/resource/default/",
	},

	touchStart(e) {
		// console.log(e.changedTouches[0].clientX)
		this.setData({
			beginx: e.changedTouches[0].clientX
		});
	},

	touchEnd(e) {
		// console.log(e.changedTouches[0].clientX)
		this.setData({
			endx: e.changedTouches[0].clientX
		});
		var offset = this.data.beginx - this.data.endx;
		var divLine = this.data.Width * 0.4;
		var value = this.data.current;
		// console.log(this.data.Width)
		if (offset < -divLine) {
			this.setData({
				current: value == 0 ? 0 : --value
			});
		} else if (offset > divLine) {
			this.setData({
				current: value == 3 ? 3 : ++value
			})
		}
		// console.log(this.data.x)
	},


	previewImage: function(e){
		var img = [];
		for (var i = 0; i < this.data.slide.length; i++) {
			img = img.concat([this.data.slide[i].slideUrl])
		}
		// console.log(img);
		wx.previewImage({
			current: img[e.currentTarget.id], // 当前显示图片的http链接
			urls: img // 需要预览的图片http链接列表
		})
	},

	/* 分栏选择 */
	onClick:function(event){
		var index = event.currentTarget.dataset.id;
		this.setData({
			current:index
		})
	},

	/* 页面数据请求 */
	onLoad: function (options) {
		var that = this;
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/getHomeInfo.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
			},
			method: 'post',
			success:function(res) {
				that.setData({
					slide: res.data.slide,
					post: res.data.post
				})
				console.log(res)
			},
			fail:function(res) {

			}
			
		})
	}, 

	/* search相关开始 */
    showInput: function () {
        this.setData({
            inputShowed: true
        });
    },
    hideInput: function () {
        this.setData({
            inputVal: "",
            inputShowed: false
		});
    },
    clearInput: function () {
        this.setData({
            inputVal: ""
        });
    },
    inputTyping: function (e) {
        this.setData({
            inputVal: e.detail.value
		});
		var that = this;
		wx.request({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/doSearch.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
				str: this.data.inputVal
			},
			method: 'GET',
			success: function(res) {
				console.log(res.data.post);
				that.setData({
					searchResult: res.data.post
				}) 			
			},
			fail: function(res) {

			}
		})  // requext
	},
	/* search相关结束 */

	// 跳转至对应帖子界面
	goPostInfo: function (event) {
		if (getApp().globalData.user.userFlag == '0') {
			this.setData({
				authFlag: true
			})
			return;
		}
		var postId = event.currentTarget.dataset.id;
		wx.navigateTo({
			url: '../postInfo/postInfo?postId=' + postId,
		})
	},

	close: function() {
		this.setData({
			authFlag: false
		})
	},
	auth: function() {
		this.setData({
			authFlag: false
		})
		wx.getUserProfile({
			desc: "获取你的昵称、头像、地区及性别",
			lang: "zh_CN",
			success: function(res) {
				console.log(res);
				var userInfo = res.userInfo;
				getApp().sendUserInfo(
					getApp().globalData.user.userId,
					userInfo.nickName,
					userInfo.gender,
					userInfo.avatarUrl
				)
			}
		})
	},

	// 页面下拉
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
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/getPostHome.php',
			header: {//json
				'content-type': 'application/x-www-form-urlencoded',
			},
			data: {
			},
			method: 'GET',
			success:function(res) {
				console.log(res)
				that.setData({
					post: res.data.post
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
	goTop: function(e) { // 一键回到顶部
		if (wx.pageScrollTo) {
			wx.pageScrollTo({
				scrollTop: 0
			})
		} else {
		wx.showModal({
				title: '提示',
				content: '当前微信版本过低，无法使用该功能，请升级到最新微信版本后重试。'
			})
		}
	},
})