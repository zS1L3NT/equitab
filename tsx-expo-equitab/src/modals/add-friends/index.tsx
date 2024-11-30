import AppList from "@/components/list"
import { getPermission } from "@/lib/permissions/contacts"
import { useNavigation } from "@react-navigation/native"
import { useEffect, useState } from "react"
import { Animated, Easing, ScrollView, Text, View, useAnimatedValue } from "react-native"
import { SafeAreaProvider } from "react-native-safe-area-context"
import type { SearchBarProps } from "react-native-screens"
import { Divider } from "react-navigation-header-buttons"

export default function AddFriendsModal() {
	const navigation = useNavigation()

	const [query, setQuery] = useState("")
	const marginTop = useAnimatedValue(108)
	useEffect(() => {
		navigation.setOptions({
			headerSearchBarOptions: {
				onChangeText: e => setQuery(e.nativeEvent.text),
				onFocus: () => {
					Animated.timing(marginTop, {
						toValue: 108 - 56,
						duration: 200,
						easing: Easing.linear,
						useNativeDriver: false,
					}).start()
				},
				onBlur: () => {
					Animated.timing(marginTop, {
						toValue: 108,
						duration: 200,
						easing: Easing.linear,
						useNativeDriver: false,
					}).start()
				},
			} satisfies SearchBarProps,
		})
	}, [marginTop, navigation])

	const [results, setResults] = useState<object[]>()
	useEffect(() => {
		if (!query) return

		// Query for search results
	}, [query])

	const [contacts, setContacts] = useState<string[] | null>()
	useEffect(() => {
		getPermission().then(async granted => {
			if (!granted) {
				setContacts(null)
				return
			}

			setContacts([])
		})
	}, [])

	const [friendables, setFriendables] = useState<object[]>()
	useEffect(() => {
		if (!contacts) return

		// Query for friendable contacts
	}, [contacts])

	return (
		<SafeAreaProvider>
			<Animated.View style={{ marginTop }}>
				<ScrollView>
					{query && (
						<>
							<Text className="ms-3.5 my-1.5 text-gray-400">Results</Text>
							<AppList items={results || Array(5).fill(null)} />
						</>
					)}

					{contacts ? (
						<>
							<Text className="ms-3.5 my-1.5 text-gray-400">Contacts</Text>
							<AppList items={friendables || Array(10).fill(null)} />
						</>
					) : (
						<View className="w-3/4 mx-auto mt-4">
							<Divider className="mb-2" />
							<Text className="text-sm text-center text-gray-400">
								{contacts === undefined
									? "Allow permission to read your contacts"
									: contacts === null
										? "We need permission to read your contacts to help you find friends more easily!"
										: "TEST TEXT"}
							</Text>
						</View>
					)}
				</ScrollView>
			</Animated.View>
		</SafeAreaProvider>
	)
}
