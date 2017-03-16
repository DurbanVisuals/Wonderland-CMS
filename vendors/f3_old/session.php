<?php

/*

	Copyright (c) 2009-2016 F3::Factory/Bong Cosca, All rights reserved.

	This file is part of the Fat-Free Framework (http://fatfreeframework.com).

	This is free software: you can redistribute it and/or modify it under the
	terms of the GNU General Public License as published by the Free Software
	Foundation, either version 3 of the License, or later.

	Fat-Free Framework is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
	General Public License for more details.

	You should have received a copy of the GNU General Public License along
	with Fat-Free Framework.  If not, see <http://www.gnu.org/licenses/>.

*/

//! Cache-based session handler
class Session {

	protected
		//! Session ID
		$sid,
		//! Anti-CSRF token
		$_csrf,
		//! User agent
		$_agent,
		//! IP,
		$_ip,
		//! Suspect callback
		$onsuspect,
		//! Cache instance
		$_cache;

	/**
	*	Open session
	*	@return TRUE
	*	@param $path string
	*	@param $name string
	**/
	function open($path,$name) {
		return TRUE;
	}

	/**
	*	Close session
	*	@return TRUE
	**/
	function close() {
		$this->sid=NULL;
		return TRUE;
	}

	/**
	*	Return session data in serialized format
	*	@return string|FALSE
	*	@param $id string
	**/
	function read($id) {
		$this->sid=$id;
		if (!$data=$this->_cache->get($id.'.@'))
			return FALSE;
		if ($data['ip']!=$this->_ip || $data['agent']!=$this->_agent) {
			$fw=Base::instance();
			if (!isset($this->onsuspect) ||
				$fw->call($this->onsuspect,[$this,$id])===FALSE) {
				//NB: `session_destroy` can't be called at that stage (`session_start` not completed)
				$this->destroy($id);
				$this->close();
				$fw->clear('COOKIE.'.session_name());
				$fw->error(403);
			}
		}
		return $data['data'];
	}

	/**
	*	Write session data
	*	@return TRUE
	*	@param $id string
	*	@param $data string
	**/
	function write($id,$data) {
		$fw=Base::instance();
		$jar=$fw->get('JAR');
		$this->_cache->set($id.'.@',
			[
				'data'=>$data,
				'ip'=>$this->_ip,
				'agent'=>$this->_agent,
				'stamp'=>time()
			],
			$jar['expire']?($jar['expire']-time()):0
		);
		return TRUE;
	}

	/**
	*	Destroy session
	*	@return TRUE
	*	@param $id string
	**/
	function destroy($id) {
		$this->_cache->clear($id.'.@');
		return TRUE;
	}

	/**
	*	Garbage collector
	*	@return TRUE
	*	@param $max int
	**/
	function cleanup($max) {
		$this->_cache->reset('.@',$max);
		return TRUE;
	}

	/**
	 *	Return session id (if session has started)
	 *	@return string|NULL
	 **/
	function sid() {
		return $this->sid;
	}

	/**
	 *	Return anti-CSRF token
	 *	@return string
	 **/
	function csrf() {
		return $this->_csrf;
	}

	/**
	 *	Return IP address
	 *	@return string
	 **/
	function ip() {
		return $this->_ip;
	}

	/**
	 *	Return Unix timestamp
	 *	@return string|FALSE
	 **/
	function stamp() {
		if (!$this->sid)
			session_start();
		return $this->_cache->exists($this->sid.'.@',$data)?
			$data['stamp']:FALSE;
	}

	/**
	 *	Return HTTP user agent
	 *	@return string
	 **/
	function agent() {
		return $this->_agent;
	}

	/**
	*	Instantiate class
	*	@param $onsuspect callback
	*	@param $key string
	**/
	function __construct($onsuspect=NULL,$key=NULL,$cache=null) {
		$this->onsuspect=$onsuspect;
		$this->_cache=$cache?:Cache::instance();
		session_set_save_handler(
			[$this,'open'],
			[$this,'close'],
			[$this,'read'],
			[$this,'write'],
			[$this,'destroy'],
			[$this,'cleanup']
		);
		register_shutdown_function('session_commit');
		$fw=\Base::instance();
		$headers=$fw->get('HEADERS');
		$this->_csrf=$fw->get('SEED').'.'.$fw->hash(mt_rand());
		if ($key)
			$fw->set($key,$this->_csrf);
		$this->_agent=isset($headers['User-Agent'])?$headers['User-Agent']:'';
		$this->_ip=$fw->get('IP');
	}

}
