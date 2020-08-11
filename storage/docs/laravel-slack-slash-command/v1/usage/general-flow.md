---
title: General flow
weight: 1
---

Whenever you type in a slash command in Slack channel, a http request will be sent to your Laravel app. You have to respond to that command within 3 seconds. Failing to do so will result in an error being displayed in the channel. In this package the initial response will be sent by a `Handler`. Learn more on [how to send the initial response](/laravel-slack-slash-command/v1/usage/sending-a-basic-response).

After that first response you're allowed to send multiple delayed responses. There are some limitations. You may respond up to 5 times within 30 minutes after the user typed in the slash command on the slack channel.
These delayed responses will be sent by queued jobs that you can dispatch using the package. Learn more on how to [send delayed responses](/laravel-slack-slash-command/v1/advanced-usage/sending-delayed-responses).

This is just a quick summary of the general flow. Before using this package it's highly recommended to go over this excellent article explaining how slash commands work, [on Slack's API site](https://api.slack.com/slash-commands).
