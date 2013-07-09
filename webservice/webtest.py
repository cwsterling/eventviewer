import web,json,os,socket,sys,uuid
from web.wsgiserver import CherryPyWSGIServer
from datetime import date
from datetime import datetime
import rethinkdb as r
from rethinkdb.errors import RqlRuntimeError
from passlib.apps import custom_app_context as pwd_context
from decimal import Decimal

CherryPyWSGIServer.ssl_certificate = "/root/keys/server.crt"
CherryPyWSGIServer.ssl_private_key = "/root/keys/server.key.new"

def removeNonAscii(s): 
	return "".join(i for i in s if ord(i)<128)

def str2bool(v):
	if(type(v) == 'unicode'):
		return v.lower() in ("yes", "true", "t", "1")
	else:
		return v


web.config.debug = True

RDB_CONFIG = {
	'host' : os.getenv('RDB_HOST', 'home.chrissterling.me'),
	'port' : os.getenv('RDB_PORT', 28015),
	'db'   : os.getenv('RDB_DB', 'race_events')
}

tables = {
	'locations'	: os.getenv('RDB_LOCATIONS','locations'),
	'tags'		: os.getenv('RDB_TAGS','tags'),
	'events' 	: os.getenv('RDB_EVENTS','events'),
	'users'		: os.getenv('RDB_USERS','users'),
	'event_tags': os.getenv('RDB_EVENT_TAGS','event_tags'),
	'images'	: os.getenv('RDB_IMAGES','images')
}

def connection():
	return r.connect(host=RDB_CONFIG['host'], port=RDB_CONFIG['port'], db=RDB_CONFIG['db'])

urls = (
	'/','index',
	'/addevent','addevent',
	'/checkslug/(.*)','checkslug',
	'/createaccount','createaccount',
	'/getzips/(.*)','getzips',
	'/geteventsbylocation/(.*)/(.*)','geteventsbylocation',
	'/geteventsbyevent/(.*)','geteventsbyevent',
	'/getevent/(.*)','getevent',
	'/gettags','gettags',
	'/login','login',
	'/suggestcity/(.*)','suggestcity'
)

class index:
	def GET(self):
		return "Hello, World! (Events Web Test)<br />Current methods allowed:<br /><table><tr><td>getzips/{zip}</td><td>pass a zip code, also pass ?range=xx if you want all the zips in a range. defaults to 10.</td></tr><tr><td>geteventsbylocation/{location}/{type}</td><td>Location: city name, state name, zip name<br />type: city,state,zip</td></tr></table>"
""" 

add event

"""
class addevent:
	def POST(self):
		i = web.input()
		eventinfo = json.loads(i.data)
		returndata = {}
		event = {}
		event['title'] = eventinfo['title']
		event['url'] = eventinfo['url']
		event['date'] = eventinfo['event_date']
		event['time'] = eventinfo['event_time']
		if(eventinfo['promote_event'] == "yes"):
			event['promoted'] = True
		else:
			event['promoted'] = False
		event['description'] = eventinfo['description']
		event['cost'] = float(str(eventinfo['cost']).strip('$'))
		tags = eventinfo['tags'].split(",")
		event['zip'] = eventinfo['zip']
		event['location'] = eventinfo['location']
		event['directions'] = eventinfo['directions']
		event['contact_name'] = eventinfo['contact_name']
		event['email'] = eventinfo['email']
		event['show_email'] = str2bool(eventinfo['show_email'])
		event['phone'] = eventinfo['phone']
		event['show_phone'] = str2bool(eventinfo['show_phone'])
		event['website'] = eventinfo['website']
		event['analytics'] = eventinfo['analytics']
		event['sponsor'] = eventinfo['sponsor']
		event['social'] = {}
		event['social']['twitter'] = eventinfo['twitter']
		event['social']['facebook'] = eventinfo['facebook']
		event['social']['gplus'] = eventinfo['gplus']
		event['created'] = str(datetime.now())
		event['created_by'] = eventinfo['created_by']

		with connection() as conn:
			insertString = r.db(RDB_CONFIG['db']).table(tables['events']).insert(event)
			insertRun = insertString.run(conn)
			key = insertRun['generated_keys'][0]
		keywords_to_insert = {}
		for keyword in tags:
			keyword_insert = {}
			clean_keyword = keyword.strip().capitalize()
			keyword_insert["event_id"] = str(key);
			keyword_insert["tag"] = clean_keyword
			keyword_insert["event_date"] = event['date']
			
			with connection() as conn:
				find_tag = r.db(RDB_CONFIG['db']).table(tables['tags']).filter(r.row['tag']==clean_keyword).count()
				find_tag_run = find_tag.run(conn)
				if(find_tag_run == 0):
					new_tag = {}
					new_tag['tag'] = clean_keyword
					insert_new_tag_string = r.db(RDB_CONFIG['db']).table(tables['tags']).insert(new_tag)
					insert_new_tag_run = insert_new_tag_string.run(conn)
				
				insert_tag_string = r.db(RDB_CONFIG['db']).table(tables['event_tags']).insert(keyword_insert)
				insert_tag_run = insert_tag_string.run(conn)
"""

check slug

""" 	     		
class checkslug:
	def GET(self,slug):
		return_data = {}
		start_info = {}
		start_info["slug"] = slug;
		with connection() as conn:
			queryString = r.db(RDB_CONFIG['db']).table(tables['events']).filter(r.row['url']==slug).count()
			query = queryString.run(conn)
			if(query == 0):
				available = True
			else:
				available = False
			return_data["available"] = available
		return json.dumps(return_data)
""" 

create account

"""
class createaccount:
	def POST(self):
		i = web.input()
		accountinfo = json.loads(i.data)
		username = accountinfo['username']
		email = accountinfo['email']
		password = accountinfo['password']
		accountinfo['admin'] = False
		passwordhash = pwd_context.encrypt(password)
		accountinfo['password'] = passwordhash

		with connection() as conn:
			emailQueryString = r.db(RDB_CONFIG['db']).table(tables['users']).filter(r.row['email'] == email).count()
			usernameQueryString = r.db(RDB_CONFIG['db']).table(tables['users']).filter(r.row['username'] == username).count()
			findEmail = emailQueryString.run(conn)
			findUsername = usernameQueryString.run(conn)
			returndata = {}
			if(findEmail == 0 and findUsername == 0):
				addAccount = r.db(RDB_CONFIG['db']).table(tables['users']).insert(accountinfo)
				addAccountResult = addAccount.run(conn)
				key = addAccountResult['generated_keys'][0]
				returndata['userdata'] = {}
				returndata['userdata']['id'] = key
				returndata['userdata']['username'] = username
				returndata['userdata']['email'] = email
				returndata['success'] = True
			else:
				returndata['success'] = False
				returndata['error'] = {}
				returndata['message'] = {}
				if(findEmail == 1):
					returndata['error']['email'] = True
					returndata['message']['email'] = 'That email address is already on file with our system. If that is yours, you can reset your password using the <a href="/account/forgotpassword">forgot password page</a>';
				if(findUsername == 1):
					returndata['error']['account'] = True
					returndata['message']['account'] = 'That username is already on file with our system. If that is yours, you can reset your password using the <a href="/account/forgotpassword">forgot password page</a>';
		return json.dumps(returndata)

""" 

get zips

"""
class getzips:
	def GET(self,location):
		i = web.input(range=10,type="zip")
		range = float(i.range)
		type = str(i.type)
		start_info = {}
		start_info["location"] = location
		start_info["search_type"] = type
		start_info["range"] = range
		return_data = {}
		with connection() as conn:
			if(type == "zip"):
				get_starting_zip = r.db(RDB_CONFIG['db']).table(tables['locations']).filter({'zip': str(location)})
			else:
				get_starting_zip = r.db(RDB_CONFIG['db']).table(tables['locations']).filter({'primary_city': str(location.capitalize())})
			result = get_starting_zip.run(conn)
			query = list(result)
			if(len(query) == 1):
				for index, item in enumerate(query):
					start_lat = item['lat']
					start_lon = item['long']
		
				lat_range_top = round(float(start_lat) + (range/49.0),2)
				lat_range_bottom = round(float(start_lat) - (range/49.0),2)
				lon_range_top = round(float(start_lon) + (range/69.0),2)
				lon_range_bottom = round(float(start_lon) - (range/69.0),2)

				queryString = r.db(RDB_CONFIG['db']).table(tables['locations']).filter( lambda row: (row['lat'] >= lat_range_bottom) & (row['lat'] <= lat_range_top) & (row['long'] <= lon_range_top) & (row['long'] >= lon_range_bottom))
				query = list(queryString.run(conn))
			zips_found = {}
			i = 0
			for index, item in enumerate(query):
				invididualZip = {}
				invididualZip['Zip'] = str(item['zip'])
				invididualZip['ID'] = str(item['id'])
				zips_found[str(i)] = invididualZip
				i += 1
			start_info['zips_found'] = len(zips_found)
			return_data["start_info"] = start_info
			return_data["zips_found"] = zips_found
	      	return json.dumps(return_data)
""" 

get events

"""
class geteventsbylocation:
	def GET(self,location,type):
		i = web.input(range=10)
		range = float(i.range)
		daterange = date.today()
		start_info = {}
		start_info["location"] = location
		start_info["search_type"] = type
		start_info["range"] = range
		return_data = {}
		try:
			with connection() as conn:
				if(type == "zip"):
					get_starting_location = r.db(RDB_CONFIG['db']).table(tables['locations']).filter({'zip': str(location)})
				elif(type == "city"):
					get_starting_location = r.db(RDB_CONFIG['db']).table(tables['locations']).filter({'primary_city': str(location.capitalize())})
				else:
					get_starting_location = r.db(RDB_CONFIG['db']).table(tables['locations']).filter({'state': str(location).upper()})			
				
				result = get_starting_location.run(conn)
				query = list(result)
				if(len(query) == 1):
					for index,item in enumerate(query):
						start_lat = item['lat']
						start_lon = item['long']
					lat_range_top = round(float(start_lat) + (range/49.0),2)
					lat_range_bottom = round(float(start_lat) - (range/49.0),2)
					lon_range_top = round(float(start_lon) + (range/69.0),2)
					lon_range_bottom = round(float(start_lon) - (range/69.0),2)

					queryString = r.db(RDB_CONFIG['db']).table(tables['locations']).filter( lambda row: (row['lat'] >= lat_range_bottom) & (row['lat'] <= lat_range_top) & (row['long'] <= lon_range_top) & (row['long'] >= lon_range_bottom))
					query = list(queryString.run(conn))

				
				zipsFound = {}
				eventsFound = {}
				events_already_added = []
				i = 0
				totalFound = 0
				zipString = ""
				for index, item in enumerate(query):
					invididualZip = {}
					invididualZip['zip'] = str(item['zip'])
					invididualZip['id'] = str(item['id'])
					zipsFound[str(i)] = invididualZip
					zipString = zipString +","+item['zip']+""
					i += 1
				zipString = zipString[1:]
	#			print(zipString)
#				eventString = r.db('race_events').table('events').filter(r.row['zip']==item['zip']).order_by(r.asc('date'))
				eventString = r.db('race_events').table('events').get_all(zipString.split(','), {'index': "zip"})
	#			print(eventString)
				eventQuery = list(eventString.run(conn))
				totalFound += len(eventQuery)
				for index, item in enumerate(eventQuery):
					individualEvent = {}
					individualEvent['Zip'] = str(item['zip'])
					individualEvent['Created'] = str(item['created'])
					individualEvent["id"] = removeNonAscii(item["id"])
					individualEvent["date"] = removeNonAscii(item["date"])
					individualEvent["title"] = removeNonAscii(item["title"])
					individualEvent["time"] = removeNonAscii(item["time"])
					individualEvent["location"] = removeNonAscii(item["location"])
					individualEvent["cost"] = item["cost"]
					individualEvent["Promoted"] = str2bool(item['promoted'])
					itemcheck = item["id"] in events_already_added
					if(itemcheck == False):
						eventsFound[str(item["id"])] = individualEvent
						events_already_added.append(item["id"])
				return_data['zips_found'] = zipsFound;
				return_data['events_found'] = eventsFound
				start_info['events_found'] = totalFound
				start_info['total_returned'] = len(eventsFound)
				return_data['start_info'] = start_info
		
		except RqlRuntimeError:
	       		print 'Database down?'
		return json.dumps(return_data)
class getevent:
	def GET(self,id):
		with connection() as conn:
			queryString = r.db(RDB_CONFIG['db']).table(tables['events']).get(id)
			query = queryString.run(conn)
			print(query)
			individualEvent = {}
			individualEvent['Zip'] = str(query['zip'])
			individualEvent["ID"] = removeNonAscii(query["id"])
			individualEvent["Date"] = removeNonAscii(query["date"])
			individualEvent["Sponsor"] = removeNonAscii(query["sponsor"])
			individualEvent["Title"] = removeNonAscii(query["title"])
			individualEvent["Description"] = removeNonAscii(query["description"])
			individualEvent["Time"] = removeNonAscii(query["time"])
			individualEvent["Location"] = removeNonAscii(query["location"])
			individualEvent["Phone"] = removeNonAscii(query["phone"])
			individualEvent["Email"] = removeNonAscii(query["email"])
			individualEvent["Website"] = removeNonAscii(query["website"])
			
			individualEvent["Social"] = query['social']
			individualEvent["Cost"] = query["cost"]
			individualEvent["Created"] = str(query['created'])
			individualEvent["Promoted"] = str2bool(query['promoted'])
			individualEvent["Tags"] = {}
			
			tag_string = r.db('race_events').table('event_tags').filter(r.row['event_id']==query['id'])
			tag_result = list(tag_string.run(conn))
			tag_id = 0
			for tag_index, tag_item in enumerate(tag_result):
				tag = {}
				tag["tag"] = tag_item["tag"]
				tag["event_id"] = query['id']
				individualEvent["Tags"][str(tag_id)] = tag
			
			
		return json.dumps(individualEvent)

class gettags:
	def GET(self):
		i = web.input(typeahead=False)
		typeahead = bool(i.typeahead)
		start_info = {}
		start_info["typeahead"] = typeahead
		return_data = {}
		with connection() as conn:
			get_tags_string = r.db('race_events').table('tags')
			result = get_tags_string.run(conn)
			tags_found = {}
			i = 0
			for index, item in enumerate(result):
				tag = {}
				tag["tag"] = item["tag"]
				tags_found[str(i)] = tag		
				i += 1

			return_data["start_info"] = start_info
			return_data["tags"] = tags_found
	      	return json.dumps(return_data)

""" 

login

"""
class login:
	def POST(self):
		i = web.input()
		accountinfo = json.loads(i.data)
		username = accountinfo['username']
		password = accountinfo['password']

		passwordhash = pwd_context.encrypt(password)

		with connection() as conn:
			if not "@" in username:
				queryString = r.db(RDB_CONFIG['db']).table(tables['users']).filter(r.row['username'] == username)
			else:
				queryString = r.db(RDB_CONFIG['db']).table(tables['users']).filter(r.row['email'] == username)
			findAccount = list(queryString.run(conn))
			returndata = {}
			if(len(findAccount) == 1):
				for index,item in enumerate(findAccount):
					ok = pwd_context.verify(password, item['password'])
					if(ok):
						returndata['userdata'] = {}
						returndata['userdata']['id'] = item['id']
						returndata['userdata']['username'] = item['username']
						returndata['userdata']['email'] = item['email']
						returndata['success'] = True
					else:
						returndata['error'] = {}
						returndata['error']['message'] = 'There was a problem logging in, password or username didn\'t match.'
						returndata['success'] = False
			else:
				returndata['success'] = False
				returndata['message'] = {}
				returndata['error'] = {}
				returndata['error']['message'] = 'I\'m sorry, we cannot find an account with that username';
		return json.dumps(returndata)


class suggestcity:
	def GET(self,zipcode):
		return_data = {}
		start_info = {}
		start_info["zip_code"] = zipcode;
		with connection() as conn:
			queryString = r.db(RDB_CONFIG['db']).table(tables['locations']).filter(r.row['zip']==zipcode)
			query = list(queryString.run(conn))
			i = 0
			for index, item in enumerate(query):
				city_info = {}
				city_info["Zip"] = item["zip"]
				city_info["City"] = item["primary_city"]
				i += 1
			return_data["city"] = city_info
		return json.dumps(return_data)


if __name__ == "__main__":
	app = web.application(urls,globals())
	app.run()

