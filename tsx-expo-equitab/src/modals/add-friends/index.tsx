import List from "@/components/list"
import { getPermission } from "@/lib/permissions/contacts"
import { useNavigation } from "@react-navigation/native"
import { useEffect, useState } from "react"
import { ScrollView, Text, View } from "react-native"
import { SafeAreaProvider, SafeAreaView } from "react-native-safe-area-context"
import type { SearchBarProps } from "react-native-screens"
import { Divider } from "react-navigation-header-buttons"

export default function AddFriendsModal() {
	const navigation = useNavigation()

	const [query, setQuery] = useState("")
	useEffect(() => {
		navigation.setOptions({
			headerSearchBarOptions: {
				onChangeText: e => setQuery(e.nativeEvent.text),
			} satisfies SearchBarProps,
		})
	}, [navigation])

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
			<SafeAreaView>
				<ScrollView>
					{/* {query && (
						<List.Container title="Results">
							{results ? (
								<></>
							) : (
								Array.from({ length: 5 }, (_, i) => (
									// biome-ignore lint/suspicious/noArrayIndexKey: No other key available
									<List.Shimmer key={i} subtitle leading />
								))
							)}
						</List.Container>
					)}

					{contacts ? (
						<List.Container title="Contacts">
							{friendables ? (
								<></>
							) : (
								Array.from({ length: 10 }, (_, i) => (
									// biome-ignore lint/suspicious/noArrayIndexKey: No other key available
									<List.Shimmer key={i} subtitle leading />
								))
							)}
						</List.Container>
					) : (
						<View className="w-3/4 mx-auto mt-4">
							<Divider className="mb-2" />
							<Text className="text-center text-sm text-gray-400">
								{contacts === undefined
									? "Allow permission to read your contacts"
									: contacts === null
										? "We need permission to read your contacts to help you find friends more easily!"
										: "TEST TEXT"}
							</Text>
						</View>
					)} */}
				</ScrollView>
			</SafeAreaView>
		</SafeAreaProvider>
	)
}
