# import re
# from urllib import request
from django.shortcuts import render


def contact(request):
	return render(request, 'core/contact.html')


def edit_profile_basic(request):
	return render(request, 'core/edit-profile-basic.html')


def edit_profile_interests(request):
    return render(request, 'core/edit-profile-interests.html')


def edit_profile_password(request):
	return render(request, 'core/edit-profile-password.html')


def edit_profile_settings(request):
	return render(request, 'core/edit-profile-settings.html')


def edit_profile_work_edu(request):
	return render(request, 'core/edit-profile-work-edu.html')


def index_register(request):
	return render(request, 'core/index-register.html')


def index(request):
	return render(request, 'core/index.html')


def newsfeed_friends(request):
	return render(request, 'core/newsfeed-friends.html')


def newsfeed_images(request):
	return render(request, 'core/newsfeed-images.html')


def newsfeed_messages(request):
	return render(request, 'core/newsfeed-messages.html')


def newsfeed_people_nearby(request):
	return render(request, 'core/newsfeed-people-nearby.html')


def newsfeed_videos(request):
	return render(request, 'core/newsfeed-videos.html')


def newsfeed(request):
	return render(request, 'core/newsfeed.html')


def timeline_about(request):
	return render(request, 'core/timeline-about.html')


def timeline_album(request):
	return render(request, 'core/timeline-album.html')


def timeline_friends(request):
	return render(request, 'core/timeline-friends.html')


def timeline(request):
	return render(request, 'core/timeline.html')


def error_404(request, exception):
    context = {}
    return render(request, 'core/404.html', context)
