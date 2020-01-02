<?php

function lang($char){
	static $lang = array(
		// wesite name
		'WESITE_NAME' => 'shop - admin',
		// globals char
		'EDIT'     => 'edit',
		'UPDATE'   => '&#xf021; update',
		'SAVE'     => 'save',
		'DELETE'   => 'delete',
		'ADD'      => 'add',
		'ACTIVATE' => 'activate',
		'APPROVE'  => 'approve',
		'INSERT'   => '&#xf1d8; insert',
		'TAGS'     => 'tags',
		'TAGS_EX'  => 'enter tags siparite by coma (ex: tag1,tag2,...)',
		// navbar characters
		'WEBSITE_NAME'  => 'shop-go',
		'CONTROL_PANEL' => '<i class="fa fa-home"></i> admin area',
		'COMMENTS'      => '<i class="fa fa-comments"></i> comments',
		'CATEGORY'  		=> '<i class="fa fa-puzzle-piece"></i> categories',
		'ITEMS'		  		=> '<i class="fa fa-shopping-cart"></i> items',
		'MEMBERS' 			=> '<i class="fa fa-users"></i> members',
		'OPTIONS'       => '<i class="fa fa-wrench"></i> options',
		'EDIT PROFIL'		=> '<i class="fa fa-edit"></i> edit profile',
		'VIS_SHOP'      => '<i class="fa fa-eye"></i> visit shop',
		'LOGOUT'  			=> '<i class="fa fa-sign-out-alt"></i> logout',
		'SETTINGS'			=> '<i class="fa fa-cogs"></i> settings',
		// Admin area page characters
		// members page
		'ADMIN_MEMBERS'   => 'administrate members',
		'CREATE_MEMBER'   => 'create member',
		'USERNAME'		    => 'username',
		'PASSWORD'		    => 'password',
		'PROFILE_IMG'     => 'profile img',
		'EMAIL'			      => 'e-mail',
		'FULLNAME'        => 'fullname',
		'LEAVEBLANC'	    => 'leave me blanc if you dont want to change',
		'ADD_MEMBER'      => 'add member',
		'ADD_NEW_MEMBER'  => 'add new member',
		'EDIT_MEMBER'     => 'edit member',
		'UPDATE_MEM'      => 'update member',
		'ACTIVATE_MEMBER' => 'activate member',
		'DELETE_MEMBER'   => 'delete member',
		'REG_DATE'        => 'register date',
		'CTRL'        => 'controlers',
		// categories page
		'ADMIN_CAT'     => 'administrate categories',
		'ADD_CAT'       => 'add categorie',
		'ADD_NEW_CAT'   => 'add new categorie',
		'CREATE_CAT'    => 'create categorie',
		'EDIT_CAT'      => 'edit categorie',
		'UPDATE_CAT'    => 'update categorie',
		'DELETE_CAT'    => 'delete categorie',
		'CAT_NAME'      => 'category name',
		'CAT_DESCR'     => 'category description',
		'CAT_ORDER'     => 'ordering',
		'VISIBLE'       => 'visible',
		'ALLOW_CMNT'    => 'allow comments',
		'ADS'           => 'allow ads',
		// items page
		'ADMIN_ITEMS'     => 'administrate items',
		'ADD_ITEM'       => 'add item',
		'ADD_NEW_ITEM' => 'add new item',
		'CREATE_ITEM'  => 'create item',
		'EDIT_ITEM'    => 'edit item',
		'UPDATE_ITEM'  => 'update item',
		'DELETE_ITEM'  => 'delete item',
		'ITEM_NAME'    => 'item name',
		'ITEM_DESCR'   => 'item description',
		'ITEM_PRICE'   => 'item price',
		'ITEM_STATUS'  => 'item status',
		'ITEM_MADE'    => 'made in',
		'MEMBER'       => 'member',
		'CAT'          => 'category',
		'EDIT_ITEM'    => 'edit item',
		'APPROVE_ITEM' => 'approve item',
		// comments page
		'ADMIN_CMNT'   => 'comments area',
		'CMNT'         => 'comment',
		'USER_CMNT'    => 'user comment',
		'ITEM'         => 'item',
		'EDIT_CMNT'    => 'edit comment',
		'UPDATE_CMNT'  => 'update comment',
		'DELETE_CMNT'  => 'delete comment',
		'APPROVE_CMNT' => 'approve comment',
		'DELETE_CMNT'  => 'delete comment',
		// settings page
		'ADMIN_SETTINGS' => 'general settings'
	);

	return $lang[$char];
}