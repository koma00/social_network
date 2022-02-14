from django.test import TestCase
from .models import User


class UserTestCase(TestCase):
    def test_user(self):
        username = 'user'
        u = User(username=username)
        self.assertEqual(u.username, username)


class IndexViewTest(TestCase):
    def test_view_url_exists_at_desired_location(self):
        response = self.client.get('/')
        self.assertEqual(response.status_code, 200)

    def test_view_uses_correct_template(self):
        response = self.client.get('/')
        self.assertEqual(response.status_code, 200)
        self.assertTemplateUsed(response, 'core/index.html')

