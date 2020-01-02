<?php

function lang($char){
	static $lang = array(
		// wesite name
		'WESITE_NAME' => 'سوق - لوحة التحكم',
		// globals char
		'EDIT'     => 'تعديل',
		'UPDATE'   => '&#xf021; تحديث',
		'SAVE'     => 'حفظ',
		'DELETE'   => 'حذف',
		'ADD'      => 'اضافة',
		'ACTIVATE' => 'تفعيل',
		'APPROVE'  => 'مواقفة',
		'INSERT'   => '&#xf1d8; ادراج',
		'TAGS'     => 'وسم',
		'TAGS_EX'  => 'ادخل الوسوم بينها فاصة (متال: وسم1, وسم2 ...)',
		// navbar characters
		'WEBSITE_NAME'  => 'سوق',
		'CONTROL_PANEL' => '<i class="fa fa-home"></i> منطقة الادارة',
		'COMMENTS'      => '<i class="fa fa-comments"></i> التعليقات',
		'CATEGORY'  		=> '<i class="fa fa-puzzle-piece"></i> الاقسام',
		'ITEMS'		  		=> '<i class="fa fa-shopping-cart"></i> العناصر',
		'MEMBERS' 			=> '<i class="fa fa-users"></i> الاعضاء',
		'OPTIONS'       => '<i class="fa fa-wrench"></i> الخيارات',
		'EDIT PROFIL'		=> '<i class="fa fa-edit"></i> تعديل الملف الشخصي',
		'VIS_SHOP'      => '<i class="fa fa-eye"></i> تفحص المتجر',
		'LOGOUT'  			=> '<i class="fa fa-sign-out-alt"></i> تسجيل الخروج',
		'SETTINGS'			=> '<i class="fa fa-cogs"></i> الاعدادات',
		// Admin area page characters
		// members page
		'ADMIN_MEMBERS'   => 'ادارة الاعضاء',
		'CREATE_MEMBER'   => 'انشاء مستخدم',
		'USERNAME'		    => 'username',
		'PASSWORD'		    => 'كلمة السر',
		'PROFILE_IMG'     => 'الصورة الشخصية',
		'EMAIL'			      => 'البريد الالكتروني',
		'FULLNAME'        => 'الاسم الكامل',
		'LEAVEBLANC'	    => 'اتركه فارغا ادا كنت لا تريد تغييره',
		'ADD_MEMBER'      => 'اضافة عضو',
		'ADD_NEW_MEMBER'  => 'اضافة عضو جديد',
		'EDIT_MEMBER'     => 'تعديل العضو',
		'UPDATE_MEM'      => 'تحديث العضو',
		'ACTIVATE_MEMBER' => 'تفعيل العضو',
		'DELETE_MEMBER'   => 'حدف العضو',
		'REG_DATE'        => 'تاريخ التسجيل',
		'CTRL'        => 'المتحكمات',
		// categories page
		'ADMIN_CAT'     => 'ادراة الاقسام',
		'ADD_CAT'       => 'اضافة قسم',
		'ADD_NEW_CAT'   => 'اضافة قسم جديد',
		'CREATE_CAT'    => 'انشاء قسم',
		'EDIT_CAT'      => 'تعديل قسم',
		'UPDATE_CAT'    => 'تحديث قسم',
		'DELETE_CAT'    => 'حدف قسم',
		'CAT_NAME'      => 'اسم القسم',
		'CAT_DESCR'     => 'وصف القسم',
		'CAT_ORDER'     => 'ترتيب',
		'VISIBLE'       => 'الظهور',
		'ALLOW_CMNT'    => 'السماح بالتعليقات',
		'ADS'           => 'السماح بالاعلانات',
		// items page
		'ADMIN_ITEMS'     => 'ادارة العناصر',
		'ADD_ITEM'       => 'اضافة عنصر',
		'ADD_NEW_ITEM' => 'اضافة عنصر جديد',
		'CREATE_ITEM'  => 'انشاء عنصر',
		'EDIT_ITEM'    => 'تعديل عنصر',
		'UPDATE_ITEM'  => 'تحديث عنصر',
		'DELETE_ITEM'  => 'حدف عنصر',
		'ITEM_NAME'    => 'اسم العنصر',
		'ITEM_DESCR'   => 'وصف العنصر',
		'ITEM_PRICE'   => 'ثمن العنصر',
		'ITEM_STATUS'  => 'حالة العنصر',
		'ITEM_MADE'    => 'صنع في',
		'MEMBER'       => 'عضو',
		'CAT'          => 'قسم',
		'EDIT_ITEM'    => 'تعديل العنصر',
		'APPROVE_ITEM' => 'الموافقة على العنصر',
		// comments page
		'ADMIN_CMNT'   => 'منطقة التعليقات',
		'CMNT'         => 'العليقات',
		'USER_CMNT'    => 'صاحب التعليق',
		'ITEM'         => 'عنصر',
		'EDIT_CMNT'    => 'تعديل التعليق',
		'UPDATE_CMNT'  => 'تحديث التعليق',
		'DELETE_CMNT'  => 'حدف التعليق',
		'APPROVE_CMNT' => 'المواقفة على التعليق',
		'DELETE_CMNT'  => 'حدف التعليق',
		// settings page
		'ADMIN_SETTINGS' => 'اعدادات عامة'
	);

	return $lang[$char];
}