import unittest
import logging
import os
from selenium import webdriver
from selenium.webdriver.common.keys import Keys

build_url = os.getenv('BUILD_URL', None)
print 'build_url: ', build_url

driver = webdriver.PhantomJS()
driver.get("http://www.python.org")
# assert "Foo" in driver.title

driver.close()
