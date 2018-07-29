#!/usr/bin/env python
# -*- coding:utf-8 -*-

from fabric.api import cd, env
from fabtools import require

env.use_ssh_config = True

env.hosts = [
    'yeeyi.app',
]  # ssh host [user@hosts:port]


def update():
    with cd('/home'):
        require.git.working_copy(
            'git@github.com:yeeyimedia/yeeyi_app_interface.git', path='app', branch='master')
