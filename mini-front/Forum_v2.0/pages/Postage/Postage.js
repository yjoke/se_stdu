// pages/Postage/Postage.js
Page({
	// mixins: [require('../../mixin/themeChanged')],
	/**
	 * 页面的初始数据
	 */
	data: {
		files: [],
		attributes: ["表白找人", "二手市场", "失物招领","其它"],
		attributeIndex: 0,  // 选择的类型
		postTitle: "",
		postText: "",
		words: 0,
		authFlag: true,
	},
	
	bindAttributeChange: function(e) {
	  console.log('picker attribute 发生选择改变，携带值为', e.detail.value);
	  this.setData({
		  attributeIndex: e.detail.value
	  })
  	},
	jumpattribute:function(){
		wx.showActionSheet({
			title:'选择帖子的属性',
			itemList: ['表白找人', '二手市场', '失物招领','其他'],
			success: function (res) {
			  if (!res.cancel) {
				console.log(res.tapIndex)//这里是点击了那个按钮的下标
			  }
			}
		})
	},


	chooseImage: function (e) {
	  var that = this;
	  wx.chooseImage({
		  sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
		  sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
		  success: function (res) {
			  // 返回选定照片的本地文件路径列表，tempFilePath可以作为img标签的src属性显示图片
			  that.setData({
				  files: that.data.files.concat(res.tempFilePaths)
			  });
		  }
	  })
	},
	previewImage: function(e){
		wx.previewImage({
			current: e.currentTarget.id, // 当前显示图片的http链接
			urls: this.data.files // 需要预览的图片http链接列表
		})
	},
	delete:function (e) {
		var index = e.currentTarget.dataset.index;
		console.log(index);
		var imgs = this.data.files;
		imgs.splice(index, 1);
		this.setData({
			files: imgs
		})
	},


	getTitle: function(e) {
		this.setData({
			postTitle: e.detail.value
		})
	},
	getText: function(e) {
		this.setData({
			postText: e.detail.value,
			words: e.detail.value.length
		})
	},

	goSuccess: function () {
		this.setData({
			postTitle: "",
			postText: "",
			files: [],
			attributeIndex: 0
		})
		wx.redirectTo({
			url: '../msg_success/msg_success',
		})
	},
	goWarn: function () {
		wx.redirectTo({
			url: '../msg_warn/msg_warn',
		})
	},

	sendPic(postId, pics, i, func) {
		// 0 的情况
		if (i == pics.length) {
			return;
		}
		var that = this;
		console.log("准备上传第 " + i + " 张图片")
		wx.uploadFile({
			url: '"这儿是请求的后端地址，需要替换成自己的"/request/sendPostImg_new.php', 
			filePath: pics[i],
			name: 'file',
			formData: {
				'postId': postId,
				'i': i
			},
			success (res){
				console.log("i = " + i + ", length = " + pics.length);
				console.log(res);
				console.log("第 " + i + " 张图片上传结束")
				if (i == pics.length - 1) {
					return;
				} else {
					func(postId, pics, i + 1, func);
				}
			},
			fail: function(res) {
				that.goWarn();
			}
		})  // uploadfile
	},
	sendPics: function(postId, pics, func) {
		this.sendPic(postId, pics, 0, this.sendPic);
		func();
	},
	// 发布评论
	submit: function(e) {
		if (getApp().globalData.user.userFlag == '0') {
			this.setData({
				authFlag: false
			})
			return;
		}
		if (!getApp().checkShut()) {
			return
		}
		if (this.data.postTitle == "" || this.data.postText == "") {
			return ;
		} else {
			var postId
			var that = this
			wx.request({
				url: '"这儿是请求的后端地址，需要替换成自己的"/request/sendPostData.php',
				header: {//json
					'content-type': 'application/x-www-form-urlencoded',
				},
				data: {
					postType: that.data.attributes[that.data.attributeIndex],
					postTitle: that.data.postTitle,
					postText: that.data.postText,
					userId: getApp().globalData.user.userId
				},
				method: 'GET',
				success:function(res) {
					postId = res.data.postId;
					console.log(res)
					var pics = that.data.files;
					that.sendPics(postId, pics, that.goSuccess);
				},
				fail: function(res) {
					that.goWarn()
				}
			})  // request
		}
		// if (that.data.sendFlag == 1) {
		// 	that.goSuccess();
		// 	that.setData({
		// 		sendFlag: 0
		// 	})
		// }
	},
	
	// 授权
	close: function() {
		this.setData({
			authFlag: true
		})
	},
	auth: function() {
		var that = this
		wx.getUserProfile({
			desc: "获取你的昵称、头像、地区及性别",
			lang: "zh_CN",
			success: function(res) {
				that.setData({
					authFlag: true
				})
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
	
})