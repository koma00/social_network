"""config URL Configuration

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/4.0/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.urls import path
from core import views

urlpatterns = [
    path('', views.index, name='index'),
    path('about', views.about, name='about'),
    path('edit-account-setting', views.edit_account_setting, name='edit-account-setting'),
    path('edit-interest', views.edit_interest, name='edit-interest'),
    path('edit-password', views.edit_password, name='edit-password'),
    path('edit-profile-basic', views.edit_profile_basic, name='edit-profile-basic'),
    path('edit-work-eductation', views.edit_work_eductation, name='edit-work-eductation'),
    path('faq', views.faq, name='faq'),
    path('groups', views.groups, name='groups'),
    path('inbox', views.inbox, name='inbox'),
    path('landing', views.landing, name='landing'),
    path('logout', views.logout, name='logout'),
    path('messages', views.messages, name='messages'),
    path('newsfeed', views.newsfeed, name='newsfeed'),
    path('notifications', views.notifications, name='notifications'),
    path('page-likers', views.page_likers, name='page-likers'),
    path('support-and-help-detail', views.support_and_help_detail, name='support-and-help-detail'),
	path('support-and-help-search-result', views.support_and_help_search_result, name='support-and-help-search-result'),
	path('support-and-help', views.support_and_help, name='support-and-help'),
    path('time-line', views.time_line, name='time-line'),
    path('timeline-friends', views.timeline_friends, name='timeline-friends'),
    path('timeline-groups', views.timeline_groups, name='timeline-groups'),
    path('timeline-pages', views.timeline_pages, name='timeline-pages'),
    path('timeline-photos', views.timeline_photos, name='timeline-photos'),
    path('timeline-videos', views.timeline_videos, name='timeline-videos')
]
