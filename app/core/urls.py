from django.urls import path
from core import views

urlpatterns = [
    path('', views.index, name='index'),
    path('contact', views.contact, name='contact'),
    path('edit-profile-basic', views.edit_profile_basic, name='edit-profile-basic'),
    path('edit-profile-interests', views.edit_profile_interests, name='edit-profile-interests'),
    path('edit-profile-password', views.edit_profile_password, name='edit-profile-password'),
    path('edit-profile-settings', views.edit_profile_settings, name='edit-profile-settings'),
    path('edit-profile-work-edu', views.edit_profile_work_edu, name='edit-profile-work-edu'),
    path('index-register', views.index_register, name='index-register'),
    path('index', views.index, name='index'),
    path('newsfeed-friends', views.newsfeed_friends, name='newsfeed-friends'),
    path('newsfeed-images', views.newsfeed_images, name='newsfeed-images'),
    path('newsfeed-messages', views.newsfeed_messages, name='newsfeed-messages'),
    path('newsfeed-people-nearby', views.newsfeed_people_nearby, name='newsfeed-people-nearby'),
    path('newsfeed-videos', views.newsfeed_videos, name='newsfeed-videos'),
    path('newsfeed', views.newsfeed, name='newsfeed'),
    path('timeline-about', views.timeline_about, name='timeline-about'),
    path('timeline-album', views.timeline_album, name='timeline-album'),
    path('timeline-friends', views.timeline_friends, name='timeline-friends'),
    path('timeline', views.timeline, name='timeline')
]
