<?php
/**
 *
 * Copyright:
 *
 * IDT Media - Goran Ilic & Tapio Löytty
 * Web: www.i-do-this.com
 * Email: hi@i-do-this.com
 *
 *
 * Authors:
 *
 * Goran Ilic, <ja@ich-mach-das.at>
 * Web: www.ich-mach-das.at
 * 
 * Tapio Löytty, <tapsa@orange-media.fi>
 * Web: www.orange-media.fi
# ListIt2 become EasyList due to the departure of the wackos in summer 2014.
#
# Jean-Christophe ghio <jcg@interphacepro.com>
#
#-------------------------------------------------------------------------
 * License:
 *-------------------------------------------------------------------------
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 * Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
 *
 * ------------------------------------------------------------------------- */

class EasyListLangOperations 
{
	private function __construct() {}

	static final public function li_lang_from_realm($originator, $args, $caller = FALSE)
	{
		global $CMS_VERSION;
		
		$instance_name = $originator;
		if($caller)
			$instance_name = $caller;		
		
		if(version_compare($CMS_VERSION, '1.99-alpha0', '<')) {
	
			$mod = cmsms()->GetModuleInstance($originator);
			if(!is_object($mod))
				throw new EasyListException('Could not retrive module instance from originator!');
				
			$mod->LoadLangMethods();
			array_unshift($args,'');
			$args[0] = &$mod;
			
			return self::clean_lang_string($instance_name, call_user_func_array('cms_module_Lang', $args));
		}
		else {
	
			array_unshift($args,'');
			$args[0] = $originator;

			return self::clean_lang_string($instance_name, CmsLangOperations::lang_from_realm($args));
		}	
	}
	
	static final public function clean_lang_string($replace, $string)
	{	
		// All magic strings here, that should be replaced from lang strings.
		return str_replace('--INSTANCE_NAME--', $replace, $string);
	}
	  	
} // end of class