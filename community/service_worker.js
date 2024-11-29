"use strict";

// ################################## CONSTANTS #################################

var CACHE_NAME = 'xf-offline';
var CACHE_ROUTE = 'index.php?sw/cache.json';
var OFFLINE_ROUTE = 'index.php?sw/offline';

var supportPreloading = false;

// ############################### EVENT LISTENERS ##############################

self.addEventListener('install', function(event)
{
	self.skipWaiting();

	event.waitUntil(createCache());
});

self.addEventListener('activate', function(event)
{
	self.clients.claim();

	event.waitUntil(
		new Promise(function(resolve)
		{
			if (self.registration.navigationPreload)
			{
				self.registration.navigationPreload[supportPreloading ? 'enable' : 'disable']();
			}

			resolve();
		})
	);
});

self.addEventListener('message', function(event)
{
	var clientId = event.source.id;
	var message = event.data;
	if (typeof message !== 'object' || message === null)
	{
		console.error('Invalid message:', message);
		return;
	}

	recieveMessage(clientId, message.type, message.payload);
});

self.addEventListener('fetch', function(event)
{
	var request = event.request,
		accept = request.headers.get('accept')

	if (
		request.mode !== 'navigate' ||
		request.method !== 'GET' ||
		(accept && !accept.includes('text/html'))
	)
	{
		return;
	}

	// bypasses for: HTTP basic auth issues, file download issues (iOS), common ad blocker issues
	if (request.url.match(/\/admin\.php|\/install\/|\/download($|&|\?)|[\/?]attachments\/|google-ad|adsense/))
	{
		if (supportPreloading && event.preloadResponse)
		{
			event.respondWith(event.preloadResponse);
		}

		return;
	}

	var response = Promise.resolve(event.preloadResponse)
		.then(function(r)
		{
			return r || fetch(request)
		});

	event.respondWith(
		response
			.catch(function(error)
			{
				return caches.open(getCacheName())
					.then(function(cache)
					{
						return cache.match(OFFLINE_ROUTE);
					});
			})
	);
});

self.addEventListener('push', function(event)
{
	if (!(self.Notification && self.Notification.permission === 'granted'))
	{
		return;
	}

	try
	{
		var data = event.data.json();
	}
	catch (e)
	{
		console.warn('Received push notification but payload not in the expected format.', e);
		console.warn('Received data:', event.data.text());
		return;
	}

	if (!data || !data.title || !data.body)
	{
		console.warn('Received push notification but no payload data or required fields missing.', data);
		return;
	}

	data.last_count = 0;

	var options = {
		body: data.body,
		dir: data.dir || 'ltr',
		data: data
	};
	if (data.badge)
	{
		options.badge = data.badge;
	}
	if (data.icon)
	{
		options.icon = data.icon;
	}

	var notificationPromise;

	if (data.tag && data.tag_phrase)
	{
		options.tag = data.tag;
		options.renotify = true;

		notificationPromise = self.registration.getNotifications({ tag: data.tag })
			.then(function(notifications)
			{
				var lastKey = (notifications.length - 1),
					notification = notifications[lastKey],
					count = 0;

				if (notification)
				{
					count = parseInt(notification.data.last_count, 10) + 1;
					options.data.last_count = count;

					options.body = options.body +  ' ' + data.tag_phrase.replace('{count}', count.toString());
				}

				return self.registration.showNotification(data.title, options);
			});
	}
	else
	{
		notificationPromise = self.registration.showNotification(data.title, options);
	}

	if ('setAppBadge' in self.navigator && 'clearAppBadge' in self.navigator)
	{
		let newCount = parseInt(String(data.total_unread).replace(/[,. ]/g, ''));

		if (newCount)
		{
			self.navigator.setAppBadge(newCount);
		}
		else
		{
			self.navigator.clearAppBadge();
		}
	}

	event.waitUntil(notificationPromise);
});

self.addEventListener('notificationclick', function(event)
{
	var notification = event.notification;

	notification.close();

	if (notification.data.url)
	{
		event.waitUntil(clients.openWindow(notification.data.url));
	}
});

// ################################## MESSAGING #################################

function sendMessage(clientId, type, payload)
{
	if (typeof type !== 'string' || type === '')
	{
		console.error('Invalid message type:', type);
		return;
	}

	if (typeof payload === 'undefined')
	{
		payload = {};
	}
	else if (typeof payload !== 'object' || payload === null)
	{
		console.error('Invalid message payload:', payload);
		return;
	}

	clients.get(clientId)
		.then(function (client)
		{
			client.postMessage({
				type: type,
				payload: payload
			});
		})
		.catch(function(error)
		{
			console.error('An error occurred while sending a message:', error);
		});
}

var messageHandlers = {};

function recieveMessage(clientId, type, payload)
{
	if (typeof type !== 'string' || type === '')
	{
		console.error('Invalid message type:', type);
		return;
	}

	if (typeof payload !== 'object' || payload === null)
	{
		console.error('Invalid message payload:', payload);
		return;
	}

	var handler = messageHandlers[type];
	if (typeof handler === 'undefined')
	{
		console.error('No handler available for message type:', type);
		return;
	}

	handler(clientId, payload);
}

// ################################### CACHING ##################################

function getCacheName()
{
	var match = self.location.pathname.match(/^\/(.*)\/[^\/]+$/);
	if (match && match[1].length)
	{
		var cacheModifier = match[1].replace(/[^a-zA-Z0-9_-]/g, '');
	}
	else
	{
		cacheModifier = '';
	}

	return CACHE_NAME + (cacheModifier.length ? '-' : '') + cacheModifier;
}

function createCache()
{
	var cacheName = getCacheName();

	return caches.delete(cacheName)
		.then(function()
		{
			return caches.open(cacheName);
		})
		.then(function(cache)
		{
			return fetch(CACHE_ROUTE)
				.then(function(response)
				{
					return response.json();
				})
				.then(function(response)
				{
					var key = response.key || null;
					var files = response.files || [];
					files.push(OFFLINE_ROUTE);

					return cache.addAll(files)
						.then(function()
						{
							return key;
						});
				});
		})
		.catch(function(error)
		{
			console.error('There was an error setting up the cache:', error);
		});
}

function updateCacheKey(clientId, key)
{
	sendMessage(clientId, 'updateCacheKey', { 'key': key });
}

messageHandlers.updateCache = function(clientId, payload)
{
	createCache();
};
