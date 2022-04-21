import re
from urllib import request
from django.shortcuts import render

def about(request):
    return render(request, 'core/about.html')

def edit_account_setting(request):
    return render(request, 'core/edit-account-setting.html')

def edit_interest(request):
    return render(request, 'core/edit-interest.html')

def edit_password(request):
    return render(request, 'core/edit-password.html')

def edit_profile_basic(request):
    return render(request, 'core/edit-profile-basic.html')

def edit_work_eductation(request):
    return render(request, 'core/edit-work-eductation.html')

def faq(request):
    return render(request, 'core/faq.html')

def groups(request):
    return render(request, 'core/groups.html')

def inbox(request):
    return render(request, 'core/inbox.html')

def index(request):
    return render(request, 'core/index.html')

def landing(request):
    return render(request, 'core/landing.html')

def logout(request):
    return render(request, 'core/logout.html')

def messages(request):
    return render(request, 'core/messages.html')

def newsfeed(request):
    return render(request, 'core/newsfeed.html')

def notifications(request):
    return render(request, 'core/notifications.html')

def page_likers(request):
    return render(request, 'core/page-likers.html')

def support_and_help_detail(request):
    return render(request, 'core/support-and-help-detail.html')
    
def support_and_help_search_result(request):
    return render(request, 'core/support-and-help-search-result.html')
    
def support_and_help(request):
    return render(request, 'core/support-and-help.html')
		
def time_line(request):
    return render(request, 'core/time-line.html')

def timeline_friends(request):
    return render(request, 'core/timeline-friends.html')

def timeline_groups(request):
    return render(request, 'core/timeline-groups.html')

def timeline_pages(request):
    return render(request, 'core/timeline-pages.html')

def timeline_photos(request):
    return render(request, 'core/timeline-photos.html')

def timeline_videos(request):
    return render(request, 'core/timeline-videos.html')

def error_404(request, exception):
    context = {}
    return render(request, 'core/404.html', context)
