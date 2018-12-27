/*自定义的js  验证方法*/
/*为了使前端提示可配置，这里不弹出了
 validate.chkRadio(name) 验证单选按钮是否被选中：name-单选按钮名
 validate.chkCheckbox(name)  验证复选按钮是否被选中：name-复选按钮名
 validate.chkUserNameNEW(obj, len) 用户名验证
 validate.checkEmail(email) 验证邮箱
 validate.checkMobilePhone(phone) 验证手机号
 
 checkTelAndPhone(phone) 验证电话和手机
 chkRealUserName(val, len)  真实姓名验证
 chkPassword(obj, len)   密码验证
 chkFloat(obj)   浮点数验证
 chkInt(obj)  验证整数
 checkRange(val,max,min) 校验数据范围
 chkAge(obj)  年龄验证
 chkURL(obj, len)  URL验证
 chkContentLen(text,maxLen,minLen)  内容长度验证
 isCardID(sId)   校验身份证
 checkDate(dateValue) 验证时间
 checkPeriod( startDate,endDate ) 检查输入的起止日期是否正确，
 checkPwdStrong(str)  验证密码复杂度（必须包含数字字母）
  
 trim(str)   去除字符两端空格
 */
;
var validate = {
	init:function(){
		//初始化
		  this.eventBind();
		   
    },
	eventBind:function(){

	 },
	//验证单选按钮是否被选中：name-单选按钮名
	 checkRadio:function  (name){
	 	if($("input[type='radio'][name='" + name + "']:checked").val()) {
	 		return true;
	 	} 
	 	return false;
	 },
	 //验证复选按钮是否被选中：name-复选按钮名
	 checkRadio:function(name) {
	 	if($("input[type='checkbox'][name='" + name + "']:checked").length) {
	 		return true;
	 	} 
	 	return false;
	 },
	//用户名验证
	 chkUserNameNEW:function(obj, len) {
	 	if("" != trim($(obj).val())) {
	 		var regex = /^[0-9a-zA-Z@._]+$/gi;
	 		var result = regex.test($(obj).val());
	 		if(result && $(obj).val().length <= len) {
	 			return true;
	 		} else if($(obj).val().length > len) {
	 			//alert("输入信息长度错误！");
	 			
	 			return false;
	 		} else {
	 			//alert("输入数据有非法字符！");
	 			
	 			return false;
	 		}
	 	}
	 	return false;
	 }  ,
	 //验证邮箱
	 checkEmail:function(email){
	 	 var regexEmial =  /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,4}$/;
	 	//var regexEmial =  /^\\w+((-\\w+)|(\\.\\w+))*\\@[A-Za-z0-9]+((\\.|-)[A-Za-z0-9]+)*\\.[A-Za-z0-9]+$/;
	 	var fromEmail = new RegExp(regexEmial);
	 	if(email == null || email == "") {
	 		//alert("邮箱不能为空，请输入常用邮箱！");
	 		return false;
	 	} else if(!fromEmail.test(email)) {
	 		//alert("邮箱格式不正确，请填写真实的Email，例如：kefu@infobigdata.com！");
	 		return false;
	 	}
	 	return true;
	 },
	 //验证手机号
	 checkMobilePhone:function (phone){
	 	//var regPhone = /^13[0-9]{9}|15[012356789][0-9]{8}|18[0123456789][0-9]{8}|147[0-9]{8}|177[0-9]{8}|170[0-9]{8}$/;
	 	var regPhone = /^(13|15|18|17|16)[0-9]{9}$/;
	 	if(phone==""){
	 		  //alert("请输入手机号");
	 	    return false;
	 	} 
	 	if(phone.length > 11) {
	 	    //alert("手机号格式不正确");
	 	 	return false;
	 	}
	 	if(!(regPhone.test(phone))){
	 	   //alert("手机号格式不正确，请填写真实的手机号，例如：139****8967！");
	 	   return false;
	 	}
	 	return true;
	 },
	 
	//验证电话和手机
	 checkTelAndPhone:function (phone){
	     var isPhone = /^([0-9]{3,4}-)?[0-9]{7,8}$/;
	     var isMob = /^13[0-9]{9}|15[012356789][0-9]{8}|18[0123456789][0-9]{8}|147[0-9]{8}|177[0-9]{8}|170[0-9]{8}$/;
	     if(isMob.test(phone) || isPhone.test(phone)){
	         return true;
	     } else {
	         return false;
	     }
	 }, 
	  
	 // 真实姓名验证
	 chkRealUserName:function (val, len) {
	 	if("" != trim(val)) {
	 		var regex = /^[\u4e00-\u9fa5]{2,}$/;
	 		var result = regex.test(val);
	 		if(result && val.length <= len) {
	 			return true;
	 		} 
	 	}
	 	return false;
	 },	  
	 //密码验证
	 chkPassword:function (obj, len) {
	 	if("" != trim($(obj).val())) {
	 		if(6 <= $(obj).val().length && $(obj).val().length <= len) {
	 			var regex = /^[a-zA-Z0-9!@#$%^&*()-_+=\[\]{}<>\/,.?]+$/gi;
	 			var result = regex.test($(obj).val());
	 			if(result) {
	 				return true;
	 			} 
	 		}  
	 	}
	 	return false;
	 },
	  
	 //浮点数验证
	 chkFloat:function (obj) {
	 	if("" != trim($(obj).val())) {
	 		var regex = /^([0-9]\.\d+|[1-9]+\.?\d+|[0-9])+$/gi;
	 		var result = regex.test(trim($(obj).val()));
	 		if(result) {
	 			if($(obj).val()<=0){
	 				//alert("请输入合理数据！");
	 				return false;
	 			}
	 			return true;
	 		} else {
	 			//alert("输入数据格式不正确！");
	 			return false;
	 		}
	 	}else{
	 		return false;
	 	}
	 	
	 },
	 //验证整数
	 chkInt:function (val) {
	 	if("" != trim(val)) {
	 		var regex = /^-?[0-9]\d*$/gi;
	 		var result = regex.test(val);
	 		if(result) {
	 			if(val<=0){
	 				//alert("请输入合理数据！");
	 				return false;
	 			}
	 			return true;
	 		} else {
	 			//alert("输入的数字不合法！");
	 			
	 			return false;
	 		}
	 	}else{
	 		return false;
	 	}
	 	
	 },
	 //校验数据范围
	 checkRange:function(val,max,min){
		 if(val <=max && val >=min){
			 return true;
		 }
		 return false;
	 },
	 //URL验证
	 chkURL:function (obj, len) {
	 	var str = "^((https|http|ftp|rtsp|mms)?://)"  
	 		+ "?(([0-9a-z_!~*'().&=+$%-]+: )?[0-9a-z_!~*'().&=+$%-]+@)?" //ftp的user@  
	 		+ "(([0-9]{1,3}\.){3}[0-9]{1,3}" // IP形式的URL- 199.194.52.184  
	 		+ "|" // 允许IP和DOMAIN（域名） 
	 		+ "([0-9a-z_!~*'()-]+\.)*" // 域名- www.  
	 		+ "([0-9a-z][0-9a-z-]{0,61})?[0-9a-z]\." // 二级域名  
	 		+ "[a-z]{2,6})" // first level domain- .com or .museum  
	 		+ "(:[0-9]{1,4})?" // 端口- :80  
	 		+ "((/?)|" // a slash isn't required if there is no file name  
	 		+ "(/[0-9a-z_!~*'().;?:@&=+$,%#-]+)+/?)$";  
	 	if("" != $(obj).val()) {
	 		var regex = new RegExp(str);
	 		var result = regex.test($(obj).val());
	 		if(result) {
	 			return true;
	 		} else {
	 			//alert("输入的URL地址信息有误！");	 			
	 			return false;
	 		}
	 	}
	 	return false;
	 	
	 }, 	 
	 //内容长度验证
	 chkContentLen:function (text,maxLen,minLen){
		  
	 	if(trim(text) == ""){
	 		//alert("请输入内容！");
	 		return false;
	 	}
	 	
	 	else if(text.replace(/[^\x00-\xff]/g,"**").length < minLen){
	 		//alert("您输入的内容太短了，请完善一下吧！");
	 		return false;
	 	}
	 	else if(text.replace(/[^\x00-\xff]/g,"**").length > maxLen){
	 		//alert("内容最多1000字哦！");
	 		return false;
	 	}
	 	return true;
	 },	   
	 // 校验身份证
	 isCardID:function (sId){  
	 	var aCity={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",  
	 			21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",  
	 			34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",  
	 			43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川"  
	 				,52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",  
	 				64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"};
	 	var iSum=0 ;  
	 	if(!/^\d{17}(\d|x)$/i.test(sId)){
	 		//alert("你输入的身份证长度或格式错误");
	 	    return false;  
	 	}
	 	sId=sId.replace(/x$/i,"a");  
	 	if(aCity[parseInt(sId.substr(0,2))]==null){
	 		//alert("你的身份证地区非法");
	 	    return false;  
	 	}
	 	sBirthday=sId.substr(6,4)+"-"+Number(sId.substr(10,2))+"-"+Number(sId.substr(12,2));  
	 	var d=new Date(sBirthday.replace(/-/g,"/")) ;  
	 	if(sBirthday!=(d.getFullYear()+"-"+ (d.getMonth()+1) + "-" + d.getDate())){
	 		//alert("身份证上的出生日期非法");
	 	    return false;  
	 	}
	 	for(var i = 17;i>=0;i --){
	 	    iSum += (Math.pow(2,i) % 11) * parseInt(sId.charAt(17 - i),11) ;  
	 	}
	 	if(iSum%11!=1){
	 		//alert("你输入的身份证号非法");
	 	    return false;  
	 	}
	 	return true;   
	 },
	
	 /**
	  * 验证时间
	  * @param dataValue 格式为：YYYY-MM-DD
	  * @returns 匹配返回true 不匹配返回false
	  */
	 checkDate:function (dateValue){
	 	var result = dateValue.match(/((^((1[8-9]\d{2})|([2-9]\d{3}))(-)(10|12|0?[13578])(-)(3[01]|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(11|0?[469])(-)(30|[12][0-9]|0?[1-9])$)|(^((1[8-9]\d{2})|([2-9]\d{3}))(-)(0?2)(-)(2[0-8]|1[0-9]|0?[1-9])$)|(^([2468][048]00)(-)(0?2)(-)(29)$)|(^([3579][26]00)(-)(0?2)(-)(29)$)|(^([1][89][0][48])(-)(0?2)(-)(29)$)|(^([2-9][0-9][0][48])(-)(0?2)(-)(29)$)|(^([1][89][2468][048])(-)(0?2)(-)(29)$)|(^([2-9][0-9][2468][048])(-)(0?2)(-)(29)$)|(^([1][89][13579][26])(-)(0?2)(-)(29)$)|(^([2-9][0-9][13579][26])(-)(0?2)(-)(29)$))/);
	 	if(result==null){
	 		return false;
	 	}
	 	return true;
	 },
	 /**
	 用途：检查输入的起止日期是否正确，规则为两个日期的格式正确 
	 且结束日期>=起始日期
	 输入：
	 startDate：起始日期，字符串
	 endDate： 结束日期，字符串
	 返回：
	 如果通过验证返回true,否则返回false
	 */
	 checkPeriod:function ( startDate,endDate ) {
		 if( !this.checkDate(startDate) ) {
			 	//alert("起始日期不正确!");
			 	return false;
		 } else if( !this.checkDate(endDate) ) {
			 	//alert("终止日期不正确!");
			 	return false;
		 } else if( startDate > endDate ) {
			 	//alert("起始日期不能大于终止日期!");
			 	return false;
		 }
		 return true;
	 }, 
	 //检查字符串是否为正确的时间区间
	 checkRangeDate:function(dateStr,splitDot){
		 var dArr = dateStr.split(splitDot);
		 if(dArr.length != 2){
			 return false;
		 }
		 return this.checkPeriod(dArr[0],dArr[1]);
	 },
	 /**
	  * 验证密码复杂度（必须包含数字字母）
	  * @param str
	  * @returns true:满足规则，false:不满足
	  */
	 checkPwdStrong:function (str){
	 	var reg1 = /^(([0-9]{1,})([a-z]{1,}))|(([a-z]{1,})([0-9]{1,}))$/;
	 	var reg2 = /^(([0-9]{1,})([A-Z]{1,}))|(([A-Z]{1,})([0-9]{1,}))$/;
	 	//var reg3 = /^([a-zA-Z]{0,})[0-9a-z-A-z]{0,}[~`!@#$%^&*.]{0,}$/;
	 	str = trim(str);
	 	//if(reg3.test(str)){
	 	//	return true;
	 	//}
	 	if(reg1.test(str)){
	 		return true;
	 	}
	 	if(reg2.test(str)){
	 		return true;
	 	}
	 	return false;
	 },


	 
	 
};


$(document).ready( function() {
    validate.init();
});

//去除字符两端空格
function trim(str) {   
  if (str != null) {  
      var i;   
      for (i=0; i<str.length; i++) {  
          if (str.charAt(i)!=" ") {  
              str=str.substring(i,str.length);   
              break;  
          }   
      }   
    
      for (i=str.length-1; i>=0; i--) {  
          if (str.charAt(i)!=" ") {  
              str=str.substring(0,i+1);   
              break;  
          }   
      }   
        
      if (str.charAt(0)==" ") {  
          return "";   
      } else {  
          return str;   
      }  
  }  
}